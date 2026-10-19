<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CourseController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $courses = $this->fetchDataFromApi($url . '/courses');

        return response()->json($courses);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $courses = $this->fetchDataFromApi($url . '/courses');

        return view('admin.courses.index', compact('courses'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $course = $this->fetchDataFromApi($url . '/courses/' . $id);

        return view('admin.courses.show', compact('course'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');
        $areas = $this->fetchDataFromApi($url . '/areas');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');
        $teachers = $this->fetchDataFromApi($url . '/teachers');

        return view('admin.courses.create', compact('areas', 'trainingCenters', 'teachers'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/courses', $request->all());
        return redirect()->route('course.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $course = $this->fetchDataFromApi($url . '/courses/' . $id);
        $course->teachers = collect($course->teachers);
        $areas = $this->fetchDataFromApi($url . '/areas');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');
        $teachers = $this->fetchDataFromApi($url . '/teachers');
        return view('admin.courses.edit', compact('course', 'areas', 'trainingCenters', 'teachers'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/courses/' . $id, $request->all());
        return redirect()->route('course.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/courses/' . $id);
        return redirect()->route('course.index');
    }

}