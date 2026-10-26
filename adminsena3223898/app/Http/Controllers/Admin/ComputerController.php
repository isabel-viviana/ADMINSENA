<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComputerRequest;
use Illuminate\Http\Request;
use App\Models\Resource\Computer;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Exception\ApiError;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

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
        $file = $data['urlFoto'];
        unset($data['urlFoto']);

        $cloudinary = new Cloudinary(config('services.cloudinary'));
        $result = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'computadores',
                'resource_type' => 'image',
            ]
        );

        $computer = Computer::create($data);
        $computer->urlFoto = $result['secure_url'];
        $computer->save();

        return response()->json($computer, 201);
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
        $data = $request->validate([
            'numero' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'urlFoto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $cloudinary = new Cloudinary(config('services.cloudinary'));

        try {
            $resultado = $cloudinary->uploadApi()->upload(
                $request->file('urlFoto')->getRealPath(),
                [
                    'folder' => 'computadores',
                    'resource_type' => 'image',
                ]
            );
        } catch (ApiError|GuzzleException $exception) {
            Log::error('Cloudinary image upload failed.', [
                'exception' => $exception::class,
                'code' => $exception->getCode(),
            ]);

            return back()->withInput()->withErrors([
                'urlFoto' => 'No se pudo subir la imagen a Cloudinary. Revisa el archivo y los registros del servidor.',
            ]);
        }

        Computer::create([
            'serial_num' => $data['numero'],
            'numero' => $data['numero'],
            'marca' => $data['marca'],
            'urlFoto' => $resultado['secure_url'],
        ]);

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
