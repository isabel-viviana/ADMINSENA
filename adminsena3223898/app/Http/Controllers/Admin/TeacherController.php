<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use Illuminate\Http\Request;
use App\Models\People\Teacher;
use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use App\Models\Academic\Course;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        $teachers = Teacher::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $courses = Course::all();

        return view('admin.teachers.create', compact('areas', 'trainingCenters', 'courses'));
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['area', 'trainingCenter', 'courses']);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function apiIndex()
    {
        return response()->json(Teacher::orderBy('id')->get());
    }

    public function apiShow(Teacher $teacher)
    {
        return response()->json($teacher->load(['area', 'trainingCenter', 'courses', 'person']));
    }

    public function apiStore(TeacherRequest $request)
    {
        $data = $request->validated();

        $courseIds = $data['courses'] ?? [];
        unset($data['courses']);
        $teacher = Teacher::create($data);
        $teacher->courses()->sync($courseIds);

        return response()->json($teacher->load(['area', 'trainingCenter', 'courses', 'person']), 201);
    }

    public function apiUpdate(TeacherRequest $request, Teacher $teacher)
    {
        $data = $request->validated();

        $courseIds = $data['courses'] ?? [];
        unset($data['courses']);
        $teacher->update($data);
        $teacher->courses()->sync($courseIds);

        return response()->json($teacher->fresh()->load(['area', 'trainingCenter', 'courses', 'person']));
    }

    public function apiDestroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $teacherData = $request->except('courses');
        $teacher = Teacher::create($teacherData);
        
        // Asignar profesores a través de la tabla intermedia
        if ($request->has('courses') && !empty($request->courses)) {
            $teacher->courses()->attach($request->courses);
        }

        $file = $request->file("urlFoto");

        if ($file) {
            $nombreArchivo = "foto_".time().".".$file->guessExtension();
            $request->file('urlFoto')->storeAs('public/images', $nombreArchivo);

            $teacher->urlFoto = $nombreArchivo;
            $teacher->save();
        }
        
        return redirect()->route('teacher.index');
    }

    public function edit(Teacher $teacher)
    {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $courses = Course::all();

        return view('admin.teachers.edit', compact('teacher', 'areas', 'trainingCenters', 'courses'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacherData = $request->except('courses');
        $teacher->update($teacherData);

        if ($request->has('courses') && !empty($request->courses)) {
            $teacher->courses()->sync($request->courses);
        } else {
            $teacher->courses()->detach();
        }

        return redirect()->route('teacher.index');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teacher.index');
    }
}
