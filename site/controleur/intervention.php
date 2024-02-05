<?php
namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function search(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $agent = $request->input('agent');

        $interventions = Intervention::where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->where('agent', 'LIKE', "%$agent%")
            ->get();

        return view('interventions', ['interventions' => $interventions]);
    }
}


?>