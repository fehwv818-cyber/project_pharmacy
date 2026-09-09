<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicines = Medicine::count();
        $totalStock = Medicine::sum('stock_quantity');
        $lowStockMedicines = Medicine::where('stock_quantity', '<=', 5)->get();

        return view('dashboard', compact('totalMedicines', 'totalStock', 'lowStockMedicines'));
    }
}