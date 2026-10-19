<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComputerRequest;
use Illuminate\Http\Request;
use App\Models\Resource\Computer;

class ComputerController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        $computers = Computer::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder->where('numero', 'like', "%{$query}%")
                        ->orWhere('marca', 'like', "%{$query}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.computers.index', compact('computers'));
    }

    public function create()
    {
        return view('admin.computers.create');
    }

    public function show(Computer $computer)
    {
        return view('admin.computers.show', compact('computer'));
    }
    
    public function apiIndex()
    {
        return response()->json(Computer::orderBy('id')->get());
    }

    public function apiShow(Computer $computer)
    {
        return response()->json($computer->load('apprentices'));
    }

    public function apiStore(ComputerRequest $request)
    {
        $data = $request->validated();

        return response()->json(Computer::create($data), 201);
    }

    public function apiUpdate(ComputerRequest $request, Computer $computer)
    {
        $data = $request->validated();

        $computer->update($data);

        return response()->json($computer->fresh());
    }

    public function apiDestroy(Computer $computer)
    {
        $computer->delete();

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $computer = Computer::create([
            'serial_num' => $request->numero,
            'numero' => $request->numero,
            'marca' => $request->marca
        ]);

        // ADJUNTAR
        $file = $request->file("urlFoto");

        if ($file) {
            $nombreArchivo = "foto_".time().".".$file->guessExtension();
            $request->file('urlFoto')->storeAs('public/images', $nombreArchivo);

            $computer->urlFoto = $nombreArchivo;
            $computer->save();
        }
         
        return redirect()->route('computer.index');
    }

    public function edit(Computer $computer)
    {
        return view('admin.computers.edit', compact('computer'));
    }

    public function update(Request $request, Computer $computer)
    {
        $computer->update([
            'serial_num' => $request->numero,
            'numero' => $request->numero,
            'marca' => $request->marca
        ]);

        return redirect()->route('computer.index');
    }

    public function destroy(Computer $computer)
    {
        $computer->delete();

        return redirect()->route('computer.index');
    }
}
