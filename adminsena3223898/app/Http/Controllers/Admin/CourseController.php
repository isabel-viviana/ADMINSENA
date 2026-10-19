<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Http\Requests\Admin\CourseFormRequest;
use Illuminate\Http\Request;
use App\Models\Academic\Course;
use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use App\Models\People\Teacher;

class CourseController extends Controller
{
    public function index(Request $request){

        $query = trim($request->query('q', ''));

        $courses = Course::query()
            ->with(['area', 'training_center'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder->where('name_curso', 'like', "%{$query}%")
                        ->orWhere('day', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('level', 'like', "%{$query}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.courses.index',compact('courses'));

    }

    public function create (){
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $teachers = Teacher::all();

        return view('admin.courses.create', compact('areas', 'trainingCenters', 'teachers'));
    }

    public function show(Course $course)
    {
        $course->load(['area', 'training_center', 'teachers']);

        return view('admin.courses.show', compact('course'));
    }

    public function apiIndex()
    {
        return response()->json(Course::with(['area', 'training_center'])->orderBy('id')->get());
    }

    public function apiShow(Course $course)
    {
        return response()->json($course->load(['area', 'training_center', 'teachers']));
    }

    public function apiStore(CourseRequest $request)
    {
        $data = $request->validated();

        $teacherIds = $data['teachers'] ?? [];
        unset($data['teachers']);
        $course = Course::create($data);
        $course->teachers()->sync($teacherIds);

        return response()->json($course->load(['area', 'training_center', 'teachers']), 201);
    }

    public function apiUpdate(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        $teacherIds = $data['teachers'] ?? [];
        unset($data['teachers']);
        $course->update($data);
        $course->teachers()->sync($teacherIds);

        return response()->json($course->fresh()->load(['area', 'training_center', 'teachers']));
    }

    public function apiDestroy(Course $course)
    {
        $course->delete();

        return response()->noContent();
    }

    public function store(CourseFormRequest $request)
    {
        $courseData = $request->validated();
        unset($courseData['teachers']);
        $course = Course::create($courseData);
        
        // Asignar profesores a través de la tabla intermedia
        if ($request->has('teachers') && !empty($request->teachers)) {
            $course->teachers()->attach($request->teachers);
        }

        $file=$request->file("urlFoto");

        if ($file) {
            $nombreArchivo = "foto_".time().".".$file->guessExtension();
            $request->file('urlFoto')->storeAs('public/images', $nombreArchivo );

            $course->urlFoto = $nombreArchivo;
            $course->save();
        }
        
        return redirect()->route('course.index');
    }

    public function edit(Course $course)
    {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $teachers = Teacher::all();

        return view('admin.courses.edit', compact('course', 'areas', 'trainingCenters', 'teachers'));
    }

    public function update(CourseFormRequest $request, Course $course)
    {
        $courseData = $request->validated();
        unset($courseData['teachers']);
        $course->update($courseData);

        if ($request->has('teachers') && !empty($request->teachers)) {
            $course->teachers()->sync($request->teachers);
        } else {
            $course->teachers()->detach();
        }

        return redirect()->route('course.index');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('course.index');
    }
}
