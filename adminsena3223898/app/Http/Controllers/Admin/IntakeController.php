<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IntakeRequest;
use App\Models\Academic\Intake as Convocatoria;
use App\Models\Academic\Course;
use App\Models\Academic\Enrollment as Inscripcion;
use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntakeController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = trim($request->query('q', ''));

        $convocatorias = $this->filteredQuery($request)
            ->orderByDesc('start_date')
            ->paginate(10)
            ->withQueryString();

        $stats = $this->aggregateStats();

        return view('admin.convocatorias.index', compact('convocatorias', 'query', 'stats'));
    }

    public function catalog(Request $request)
    {
        $this->ensureApprentice();

        $convocatorias = $this->filteredQuery($request)
            ->where('status', 'Abierta')
            ->orderBy('start_date')
            ->get();

        $inscritos = Inscripcion::query()
            ->where('user_id', Auth::id())
            ->where('status', 'Inscrito')
            ->pluck('convocatoria_id')
            ->all();

        $areas = Area::orderBy('name')->get();
        $trainingCenters = TrainingCenter::orderBy('name')->get();

        return view('aspirant.convocatorias.catalog', [
            'convocatorias' => $convocatorias,
            'inscritos' => $inscritos,
            'filters' => $request->only(['programa', 'area_id', 'training_center_id', 'modality', 'schedule']),
            'areas' => $areas,
            'trainingCenters' => $trainingCenters,
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();

        $courses = Course::orderBy('name_curso')->get();
        $trainingCenters = TrainingCenter::orderBy('name')->get();

        return view('admin.convocatorias.create', compact('courses', 'trainingCenters'));
    }
    
    public function apiIndex()
    {
        return response()->json(Convocatoria::orderBy('id')->get());
    }

    public function store(IntakeRequest $request)
    {
        $this->ensureAdmin();

        Convocatoria::create($request->validated());

        return redirect()->route('convocatoria.index');
    }

    public function edit(Convocatoria $convocatoria)
    {
        $this->ensureAdmin();

        $courses = Course::orderBy('name_curso')->get();
        $trainingCenters = TrainingCenter::orderBy('name')->get();

        return view('admin.convocatorias.edit', compact('convocatoria', 'courses', 'trainingCenters'));
    }

    public function update(IntakeRequest $request, Convocatoria $convocatoria)
    {
        $this->ensureAdmin();

        $convocatoria->update($request->validated());

        return redirect()->route('convocatoria.index');
    }

    public function detail(Convocatoria $convocatoria)
    {
        $this->ensureApprentice();

        $convocatoria->load(['course', 'trainingCenter']);
        $inscritos = Inscripcion::query()
            ->where('user_id', Auth::id())
            ->where('convocatoria_id', $convocatoria->id)
            ->where('status', 'Inscrito')
            ->exists();
        $stats = $this->statsFor(collect([$convocatoria]))[$convocatoria->id];

        return view('aspirant.convocatorias.detail', compact('convocatoria', 'inscritos', 'stats'));
    }

    public function adminStats(Convocatoria $convocatoria)
    {
        $this->ensureAdmin();

        $convocatoria->load(['course', 'trainingCenter']);
        $stats = $this->aggregateStats();
        $query = '';
        $convocatorias = Convocatoria::query()
            ->with(['course', 'trainingCenter'])
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('admin.convocatorias.index', compact('convocatorias', 'query', 'stats', 'convocatoria'));
    }

    private function statsFor($convocatorias): array
    {
        $ids = $convocatorias->pluck('id');
        $inscritosPorConvocatoria = Inscripcion::query()
            ->whereIn('convocatoria_id', $ids)
            ->where('status', 'Inscrito')
            ->select('convocatoria_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('convocatoria_id')
            ->pluck('total', 'convocatoria_id');

        return $convocatorias->mapWithKeys(function (Convocatoria $convocatoria) use ($inscritosPorConvocatoria) {
            $inscritos = (int) ($inscritosPorConvocatoria[$convocatoria->id] ?? 0);
            $disponibles = (int) $convocatoria->quota;
            $totales = $disponibles + $inscritos;

            return [$convocatoria->id => [
                'total' => $totales,
                'inscritos' => $inscritos,
                'disponibles' => $disponibles,
                'porcentaje' => $totales > 0 ? round(($inscritos / $totales) * 100) : 0,
            ]];
        })->all();
    }

    private function filteredQuery(Request $request)
    {
        return Convocatoria::query()
            ->with(['course', 'trainingCenter'])
            ->when($request->filled('q'), function ($builder) use ($request) {
                $query = trim($request->query('q'));
                $builder->where(function ($search) use ($query) {
                    $search->whereHas('course', function ($courseQuery) use ($query) {
                        $courseQuery->where('name_curso', 'like', "%{$query}%");
                    })->orWhereHas('trainingCenter', function ($centerQuery) use ($query) {
                        $centerQuery->where('name', 'like', "%{$query}%");
                    });
                });
            })
            ->when($request->filled('programa'), function ($builder) use ($request) {
                $builder->whereHas('course', function ($courseQuery) use ($request) {
                    $courseQuery->where('name_curso', 'like', '%' . trim($request->query('programa')) . '%');
                });
            })
            ->when($request->filled('area_id'), function ($builder) use ($request) {
                $builder->whereHas('course', function ($courseQuery) use ($request) {
                    $courseQuery->where('area_id', $request->query('area_id'));
                });
            })
            ->when($request->filled('training_center_id'), fn ($builder) => $builder->where('training_center_id', $request->query('training_center_id')))
            ->when($request->filled('modality'), fn ($builder) => $builder->where('modality', $request->query('modality')))
            ->when($request->filled('schedule'), fn ($builder) => $builder->where('schedule', $request->query('schedule')));
    }

    private function aggregateStats(): array
    {
        $stats = $this->statsFor(Convocatoria::query()->get());

        $total = array_reduce($stats, function (array $total, array $current): array {
            $total['total'] += $current['total'];
            $total['inscritos'] += $current['inscritos'];
            $total['disponibles'] += $current['disponibles'];

            return $total;
        }, ['total' => 0, 'inscritos' => 0, 'disponibles' => 0]);

        $total['porcentaje'] = $total['total'] > 0
            ? round(($total['inscritos'] / $total['total']) * 100)
            : 0;

        return $total;
    }

    private function ensureApprentice(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        abort_unless(Auth::user()->role === 'aprendiz', 403);
    }

    private function ensureAdmin(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        abort_unless(Auth::user()->role === 'admin', 403);
    }
}
