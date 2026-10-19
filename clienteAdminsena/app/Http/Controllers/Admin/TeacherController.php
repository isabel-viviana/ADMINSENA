<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeacherController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $teachers = $this->fetchDataFromApi($url . '/teachers');

        return response()->json($teachers);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $teachers = $this->fetchDataFromApi($url . '/teachers');

        return view('admin.teachers.index', compact('teachers'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $teacher = $this->fetchDataFromApi($url . '/teachers/' . $id);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');
        $areas = $this->fetchDataFromApi($url . '/areas');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');
        $courses = $this->fetchDataFromApi($url . '/courses');

        return view('admin.teachers.create', compact('areas', 'trainingCenters', 'courses'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/teachers', $request->all());
        return redirect()->route('teacher.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $teacher = $this->fetchDataFromApi($url . '/teachers/' . $id);
        $teacher->courses = collect($teacher->courses);
        $areas = $this->fetchDataFromApi($url . '/areas');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');
        $courses = $this->fetchDataFromApi($url . '/courses');
        return view('admin.teachers.edit', compact('teacher', 'areas', 'trainingCenters', 'courses'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/teachers/' . $id, $request->all());
        return redirect()->route('teacher.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/teachers/' . $id);
        return redirect()->route('teacher.index');
    }
}