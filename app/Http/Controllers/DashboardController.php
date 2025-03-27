<?php

namespace App\Http\Controllers;

use App\Models\Employeee;
use App\Models\Secondment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employeee::whereIn('employmentStatus', ['active', 'retired'])->count();
        $activeEmployees = Employeee::where('employmentStatus', 'active')->count();
        $retiredEmployees = Employeee::where('employmentStatus', 'retired')->count();
        $highlightedEmployees = Secondment::distinct('employeeId')->count('employeeId');

        $hiredPerMonth = Employeee::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $months = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        $hiredData = array_fill_keys(array_values($months), 0);
        foreach ($hiredPerMonth as $data) {
            $hiredData[$months[$data->month]] = $data->count;
        }

        return view('dashboard.index', compact(
            'totalEmployees',
            'activeEmployees',
            'retiredEmployees',
            'highlightedEmployees',
            'hiredData'
        ));
    }
}