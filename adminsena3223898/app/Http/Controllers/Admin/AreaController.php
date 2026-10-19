<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaRequest;
use Illuminate\Http\Request;
use App\Models\Catalog\Area;

class AreaController extends Controller{


    public function consulta1(){
        $respuesta = Area::with(['apprentice.teacher'])->get();
        return response()->json($respuesta);
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        $areas = Area::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where('name', 'like', "%{$query}%");
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.areas.index', compact('areas'));
    }

    public function show(Area $area)
    {
        return view('admin.areas.show', compact('area'));
    }

    public function apiIndex()
    {
        return response()->json(Area::orderBy('id')->get());
    }

    public function apiShow(Area $area)
    {
        return response()->json($area);
    }

    public function apiStore(AreaRequest $request)
    {
        $data = $request->validated();

        return response()->json(Area::create($data), 201);
    }

    public function apiUpdate(AreaRequest $request, Area $area)
    {
        $data = $request->validated();

        $area->update($data);

        return response()->json($area->fresh());
    }

    public function apiDestroy(Area $area)
    {
        $area->delete();

        return response()->noContent();
    }

    public function store(Request $request)
    {
        Area::create([
            'name' => $request->name
        ]);

        return redirect()->route('area.index');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $area->update([
            'name' => $request->name
        ]);

        return redirect()->route('area.index');
    }

    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('area.index');
    }
}
