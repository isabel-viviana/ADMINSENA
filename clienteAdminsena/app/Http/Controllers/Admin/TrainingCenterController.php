<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrainingCenterController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');

        return response()->json($trainingCenters);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');

        return view('admin.training-centers.index', compact('trainingCenters'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $trainingCenter = $this->fetchDataFromApi($url . '/training-centers/' . $id);

        return view('admin.training-centers.show', compact('trainingCenter'));
    }

    public function create()
    {
        return view('admin.training-centers.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/training-centers', $request->all());
        return redirect()->route('trainingCenter.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $trainingCenter = $this->fetchDataFromApi($url . '/training-centers/' . $id);
        return view('admin.training-centers.edit', compact('trainingCenter'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/training-centers/' . $id, $request->all());
        return redirect()->route('trainingCenter.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/training-centers/' . $id);
        return redirect()->route('trainingCenter.index');
    }
}