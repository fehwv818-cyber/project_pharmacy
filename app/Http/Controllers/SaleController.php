<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Sale;

class SaleController extends Controller
{
    public function create()
    {
        $medicines = Medicine::where('stock_quantity', '>', 0)->get();
        return view('sales.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);

        if ($medicine->stock_quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'الكمية المطلوبة غير متوفرة في المخزن! الرصيد الحالي: ' . $medicine->stock_quantity]);
        }

        $totalPrice = $medicine->selling_price * $request->quantity;
        $itemProfit = ($medicine->selling_price - $medicine->purchase_price) * $request->quantity;

        $sale = Sale::create([
            'medicine_id' => $medicine->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'profit' => $itemProfit,
        ]);

        $medicine->stock_quantity -= $request->quantity;
        $medicine->save();

        $invoiceData = [
            'medicine_name' => $medicine->name,
            'quantity' => $request->quantity,
            'unit_price' => $medicine->selling_price,
            'total_price' => $totalPrice,
        ];

        return redirect()->route('sales.create')
            ->with('success', 'تمت عملية البيع بنجاح!')
            ->with('invoice', $invoiceData);
    }

    public function report()
    {
        $sales = Sale::with('medicine')->latest()->get();
        $totalSalesAmount = $sales->sum('total_price');
        $totalProfitAmount = $sales->sum('profit');

        return view('sales.report', compact('sales', 'totalSalesAmount', 'totalProfitAmount'));
    }

    // دالة عرض الفاتورة الجديدة
    public function invoice($id)
    {
        $sale = Sale::with('medicine')->findOrFail($id);
        return view('sales.invoice', compact('sale'));
    }
}