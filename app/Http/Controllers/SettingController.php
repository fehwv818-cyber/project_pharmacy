<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first() ?? new Setting();
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        $setting->pharmacy_name = $request->pharmacy_name;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->save();

        return back()->with('success', 'تم حفظ إعدادات الصيدلية بنجاح!');
    }
}