<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class ReportController extends Controller
{
    public function index()
    {
        $totalSales = Sale::sum('total_price');
        
        $salesCount = Sale::count();

        $latestSales = Sale::with('medicine')->latest()->take(10)->get();

        return view('reports.index', compact('totalSales', 'salesCount', 'latestSales'));
    }
}