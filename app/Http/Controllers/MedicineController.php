<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $medicines = Medicine::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        })->get();

        return view('medicines.index', compact('medicines', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('medicines.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255', // تم إضافتها لضمان حفظ الباركود
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'expire_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($data);

        return redirect()->route('medicines.index')->with('success', 'تم إضافة الدواء بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('medicines.edit', compact('medicine', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255', // تم إضافتها هنا أيضاً
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'expire_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        return redirect()->route('medicines.index')->with('success', 'تم تحديث بيانات الدواء بنجاح!');
    }

    /**
     * Search API for POS / Sales screen.
     */
    public function searchApi(Request $request)
    {
        $query = $request->input('q');

        $medicines = Medicine::where('name', 'LIKE', "%{$query}%")
            ->orWhere('barcode', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($medicines);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'تم حذف الدواء بنجاح!');
    }
}