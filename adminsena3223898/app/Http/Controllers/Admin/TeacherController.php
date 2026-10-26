<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use Illuminate\Http\Request;
use App\Models\People\Teacher;
use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use App\Models\Academic\Course;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Exception\ApiError;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

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

        $file = $data['urlFoto'];
        unset($data['urlFoto']);
        $courseIds = $data['courses'] ?? [];
        unset($data['courses']);

        $cloudinary = new Cloudinary(config('services.cloudinary'));
        $result = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'docentes',
                'resource_type' => 'image',
            ]
        );

        $teacher = Teacher::create($data);
        $teacher->urlFoto = $result['secure_url'];
        $teacher->save();
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
        $data = $request->validate([
            'urlFoto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $cloudinary = new Cloudinary(config('services.cloudinary'));

        try {
            $result = $cloudinary->uploadApi()->upload(
                $data['urlFoto']->getRealPath(),
                [
                    'folder' => 'docentes',
                    'resource_type' => 'image',
                ]
            );
        } catch (ApiError|GuzzleException $exception) {
            Log::error('Cloudinary teacher image upload failed.', [
                'exception' => $exception::class,
                'code' => $exception->getCode(),
            ]);

            return back()->withInput()->withErrors([
                'urlFoto' => 'No se pudo subir la imagen a Cloudinary. Revisa el archivo y los registros del servidor.',
            ]);
        }

        $teacherData = $request->except(['courses', 'urlFoto']);
        $teacher = Teacher::create($teacherData);
        $teacher->urlFoto = $result['secure_url'];
        $teacher->save();

        if ($request->has('courses') && !empty($request->courses)) {
            $teacher->courses()->attach($request->courses);
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
