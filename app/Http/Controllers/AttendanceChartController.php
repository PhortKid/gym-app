<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceChartController extends Controller
{

public function attendanceChart(Request $request)
{
    $filter = $request->input('filter', 'week'); // default week

    $query = Attendance::query();

    if ($filter === 'week') {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $data = $query->whereBetween('time_in', [$startDate, $endDate])
            ->selectRaw('DATE(time_in) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    } elseif ($filter === 'month') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $data = $query->whereBetween('time_in', [$startDate, $endDate])
            ->selectRaw('DATE(time_in) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    } elseif ($filter === 'year') {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        $data = $query->whereBetween('time_in', [$startDate, $endDate])
            ->selectRaw('MONTHNAME(time_in) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderByRaw('MONTH(time_in)')
            ->get();
    }

    return response()->json($data);
}

}