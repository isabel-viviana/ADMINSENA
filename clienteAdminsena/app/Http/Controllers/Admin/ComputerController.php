<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ComputerController extends Controller 
{
    private function fetchDataFromApi(String $url)
    {
        $response = Http::get($url);
        return json_decode($response->body());
    }

    public function apiIndex()
    {
        $url = env('URL_SERVER_API');
        $computers = $this->fetchDataFromApi($url . '/computers');

        return response()->json($computers);
    }

    public function index() 
    {

        $url = env('URL_SERVER_API');

        $computers = $this->fetchDataFromApi($url . '/computers');

        return view('admin.computers.index', compact('computers'));
    }

    public function show(Int $id)
    {

        $url = env('URL_SERVER_API');

        $computer = $this->fetchDataFromApi($url . '/computers/' . $id);

        return view('admin.computers.show', compact('computer'));
    }

    public function create()
    {
        return view('admin.computers.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        Http::post($url . '/computers', [
            'serial_num' => $request->numero,
            'numero' => $request->numero,
            'marca' => $request->marca,
        ]);
        return redirect()->route('computer.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $computer = $this->fetchDataFromApi($url . '/computers/' . $id);
        return view('admin.computers.edit', compact('computer'));
    }

    public function update(Request $request, Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::put($url . '/computers/' . $id, [
            'serial_num' => $request->numero,
            'numero' => $request->numero,
            'marca' => $request->marca,
        ]);
        return redirect()->route('computer.index');
    }

    public function destroy(Int $id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/computers/' . $id);
        return redirect()->route('computer.index');
    }
}