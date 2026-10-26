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
        $data = $request->validate([
            'numero' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'urlFoto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $file = $request->file('urlFoto');
        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = Http::attach(
            'urlFoto',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post($url . '/computers', [
            'serial_num' => $data['numero'],
            'numero' => $data['numero'],
            'marca' => $data['marca'],
        ]);

        if (!$response->successful()) {
            return back()
                ->withErrors($response->json('errors', [
                    'urlFoto' => 'No se pudo registrar el computador.',
                ]))
                ->withInput();
        }

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