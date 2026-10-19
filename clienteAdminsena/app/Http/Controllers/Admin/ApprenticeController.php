<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApprenticeController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $apprentices = $this->fetchDataFromApi($url . '/apprentices');

        return response()->json($apprentices);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $apprentices = $this->fetchDataFromApi($url . '/apprentices');

       return view('admin.apprentices.index', compact('apprentices'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $apprentice = $this->fetchDataFromApi($url . '/apprentices/' . $id);

        return view('admin.apprentices.show', compact('apprentice'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');
        $courses = $this->fetchDataFromApi($url . '/courses');
        $computers = $this->fetchDataFromApi($url . '/computers');

        return view('admin.apprentices.create', compact('courses', 'computers'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/apprentices', $request->all());
        return redirect()->route('apprentice.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $apprentice = $this->fetchDataFromApi($url . '/apprentices/' . $id);
        $courses = $this->fetchDataFromApi($url . '/courses');
        $computers = $this->fetchDataFromApi($url . '/computers');
        
        return view('admin.apprentices.edit', compact('apprentice', 'courses', 'computers'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/apprentices/' . $id, $request->all());
        return redirect()->route('apprentice.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/apprentices/' . $id);
        return redirect()->route('apprentice.index');
    }

}