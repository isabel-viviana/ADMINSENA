<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainingCenterRequest;
use Illuminate\Http\Request;
use App\Models\Catalog\TrainingCenter;

class TrainingCenterController extends Controller
{
    public function index(Request $request){

        $query = trim($request->query('q', ''));

        $trainingCenters = TrainingCenter::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.training-centers.index',compact('trainingCenters'));

    }

    public function create (){

        return view('admin.training-centers.create');

    }

    public function show(TrainingCenter $trainingCenter)
    {
        return view('admin.training-centers.show', compact('trainingCenter'));
    }
    
    public function apiIndex()
    {
        return response()->json(TrainingCenter::orderBy('id')->get());
    }

    public function apiShow(TrainingCenter $trainingCenter)
    {
        return response()->json($trainingCenter);
    }

    public function apiStore(TrainingCenterRequest $request)
    {
        $data = $request->validated();

        return response()->json(TrainingCenter::create($data), 201);
    }

    public function apiUpdate(TrainingCenterRequest $request, TrainingCenter $trainingCenter)
    {
        $data = $request->validated();

        $trainingCenter->update($data);

        return response()->json($trainingCenter->fresh());
    }

    public function apiDestroy(TrainingCenter $trainingCenter)
    {
        $trainingCenter->delete();

        return response()->noContent();
    }

    public function store(Request $request){
        $trainingCenter = TrainingCenter::create([
            'name' => $request->name,
            'location' => $request->location
        ]);
        return redirect()->route('trainingCenter.index');
    }

    public function edit(TrainingCenter $trainingCenter)
    {
        return view('admin.training-centers.edit', compact('trainingCenter'));
    }

    public function update(Request $request, TrainingCenter $trainingCenter)
    {
        $trainingCenter->update([
            'name' => $request->name,
            'location' => $request->location
        ]);

        return redirect()->route('trainingCenter.index');
    }

    public function destroy(TrainingCenter $trainingCenter)
    {
        $trainingCenter->delete();

        return redirect()->route('trainingCenter.index');
    }
}
