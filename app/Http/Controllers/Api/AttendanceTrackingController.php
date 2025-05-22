<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceTrackingController extends Controller
{
            public function attendanceSummary($id)
        {
            $customer = Customer::findOrFail($id);

            $startDate = Carbon::parse($customer->start_date);
            $endDate = Carbon::parse($customer->expiry_date);

            $totalDays = $startDate->diffInDays($endDate) + 1; // jumla ya siku alizopangiwa

            $attendanceCount = Attendance::where('member_id', $id)
                ->whereDate('time_in', '>=', $startDate)
                ->whereDate('time_in', '<=', $endDate)
                ->distinct('time_in') // kama mtu anaweza kuingia zaidi ya mara 1 kwa siku
                ->count();

            return response()->json([
                'customer_name' => $customer->full_name,
                'start_date' => $startDate->toDateString(),
                'expiry_date' => $endDate->toDateString(),
                'assigned_days' => $totalDays,
                'attended_days' => $attendanceCount,
                'remaining_days' => max(0, $totalDays - $attendanceCount),
                'status' => $attendanceCount >= $totalDays ? 'Limit Reached' : 'Active',
            ]);
        }

        public function allCustomersAttendance()
{
   /* $customers = Customer::all();

    $data = $customers->map(function ($customer) {
        $startDate = Carbon::parse($customer->start_date);
        $endDate = Carbon::parse($customer->expiry_date);

        $assignedDays = $startDate->diffInDays($endDate) + 1;

        $attendedDays = Attendance::where('member_id', $customer->id)
            ->whereDate('time_in', '>=', $startDate)
            ->whereDate('time_in', '<=', $endDate)
            ->distinct('time_in') // avoid counting same day twice
            ->count();

        return [
            'customer_name' => $customer->full_name,
            'start_date' => $startDate->toDateString(),
            'expiry_date' => $endDate->toDateString(),
            'assigned_days' => $assignedDays,
            'attended_days' => $attendedDays,
            'remaining_days' => max(0, $assignedDays - $attendedDays),
            'status' => $attendedDays >= $assignedDays ? 'Limit Reached' : 'Active'
        ];
    });

    return response()->json($data);*/

    $customers = Customer::all();
    $today = Carbon::today();

    $data = $customers->map(function ($customer) use ($today) {
        $startDate = Carbon::parse($customer->start_date);
        $originalExpiryDate = Carbon::parse($customer->expiry_date);

        // Hesabu assigned days
        $assignedDays = $startDate->diffInDays($originalExpiryDate) + 1;

        // Attended days
        $attendedDays = Attendance::where('member_id', $customer->id)
            ->whereDate('time_in', '>=', $startDate)
            ->whereDate('time_in', '<=', $originalExpiryDate)
            ->distinct('time_in')
            ->count();

        // Missed and remaining days
        $missedDays = max(0, $assignedDays - $attendedDays);
        $remainingDays = $missedDays;

        // Logic ya ku-extend
        if ($today->lte($originalExpiryDate)) {
            // Bado yupo ndani ya muda wake, hatuongezi siku
            $extendedExpiryDate = $originalExpiryDate;
        } else {
            // Kama expiry imepita na bado hajamaliza siku zake
            $extendedExpiryDate = $missedDays > 0
                ? $originalExpiryDate->copy()->addDays($missedDays)
                : $originalExpiryDate;
        }

        // Status
        $status = $today->lte($extendedExpiryDate) ? 'Active' : 'Limit Reached';

        return [
            'customer_name' => $customer->full_name,
            'start_date' => $startDate->toDateString(),
            'original_expiry_date' => $originalExpiryDate->toDateString(),
            'extended_expiry_date' => $extendedExpiryDate->toDateString(),
            'assigned_days' => $assignedDays,
            'attended_days' => $attendedDays,
            'missed_days' => $missedDays,
            'remaining_days' => $remainingDays,
            'status' => $status,
        ];
    });

    return response()->json($data);
}

}
