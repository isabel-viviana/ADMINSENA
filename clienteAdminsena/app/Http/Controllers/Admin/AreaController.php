<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AreaController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $areas = $this->fetchDataFromApi($url . '/areas');

        return response()->json($areas);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $areas = $this->fetchDataFromApi($url . '/areas');

        return view('admin.areas.index', compact('areas'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $area = $this->fetchDataFromApi($url . '/areas/' . $id);

        return view('admin.areas.show', compact('area'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/areas', $request->all());
        return redirect()->route('area.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $area = $this->fetchDataFromApi($url . '/areas/' . $id);
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/areas/' . $id, $request->all());
        return redirect()->route('area.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/areas/' . $id);
        return redirect()->route('area.index');
    }
}
