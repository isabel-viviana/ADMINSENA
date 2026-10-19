<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApprenticeRequest;
use Illuminate\Http\Request;
use App\Models\Academic\Apprentice;
use App\Models\Academic\Course;
use App\Models\Resource\Computer;

class ApprenticeController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        $apprentices = Apprentice::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder->where('id', 'like', "%{$query}%")
                        ->orWhere('name_apren', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('cell', 'like', "%{$query}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.apprentices.index', compact('apprentices'));
    }

    public function create()
    {
        $courses = Course::all();
        $computers = Computer::all();

        return view('admin.apprentices.create', compact('courses', 'computers'));
    }

    public function show(Apprentice $apprentice)
    {
        $apprentice->load(['course', 'computer']);

        return view('admin.apprentices.show', compact('apprentice'));
    }

    public function apiIndex()
    {
        return response()->json(Apprentice::orderBy('id')->get());
    }

    public function apiShow(Apprentice $apprentice)
    {
        return response()->json($apprentice->load(['program', 'course', 'computer', 'person', 'intake', 'enrollment']));
    }

    public function apiStore(ApprenticeRequest $request)
    {
        $data = $request->validated();

        return response()->json(Apprentice::create($data), 201);
    }

    public function apiUpdate(ApprenticeRequest $request, Apprentice $apprentice)
    {
        $data = $request->validated();

        $apprentice->update($data);

        return response()->json($apprentice->fresh());
    }

    public function apiDestroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $apprentice = Apprentice::create($request->all());
        $file = $request->file("urlFoto");

        if ($file) {
            $nombreArchivo = "foto_".time().".".$file->guessExtension();
            $request->file('urlFoto')->storeAs('public/images', $nombreArchivo);

            $apprentice->urlFoto = $nombreArchivo;
            $apprentice->save();
        }

        return redirect()->route('apprentice.index');
    }

    public function edit(Apprentice $apprentice)
    {
        $courses = Course::all();
        $computers = Computer::all();

        return view('admin.apprentices.edit', compact('apprentice', 'courses', 'computers'));
    }

    public function update(Request $request, Apprentice $apprentice)
    {
        $apprentice->update($request->all());

        return redirect()->route('apprentice.index');
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return redirect()->route('apprentice.index');
    }
}
