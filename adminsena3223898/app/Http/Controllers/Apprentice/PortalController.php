<?php

namespace App\Http\Controllers\Apprentice;

use App\Http\Controllers\Controller;
use App\Models\Academic\Enrollment;
use App\Models\Academic\Intake;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        abort_unless(Auth::user()->role === 'aprendiz', 403);

        $personaId = Auth::user()->person?->id;
        $convocatorias = Intake::query()
            ->with(['course', 'trainingCenter'])
            ->where('status', 'Abierta')
            ->where('quota', '>', 0)
            ->orderBy('start_date')
            ->get();
        $inscritos = $personaId
            ? Enrollment::where('persona_id', $personaId)
                ->where('status', 'Inscrito')
                ->pluck('convocatoria_id')
                ->all()
            : [];

        return view('apprentice.dashboard', compact('convocatorias', 'inscritos'));
    }
}
