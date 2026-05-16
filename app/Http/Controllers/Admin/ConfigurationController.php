<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    public function index()
    {
        $config = Configuration::first();

        return view('admin.site.config', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_url' => ['nullable', 'string', 'max:255'],
            'admin_email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:30'],

            'site_description' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],

            'instagram' => ['nullable', 'string'],
            'telegram' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string'],
            'youtube' => ['nullable', 'string'],

            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $config = Configuration::first();

        if (! $config) {
            $config = new Configuration();
        }

        $data = $request->except('site_logo');

        $data['site_status'] = $request->has('site_status');
        $data['maintenance_mode'] = $request->has('maintenance_mode');

        if ($request->hasFile('site_logo')) {

            $logo = $request->file('site_logo');

            $filename = time() . '_' . $logo->getClientOriginalName();

            $logo->move(public_path('uploads/site/logo'), $filename);

            $data['site_logo'] = 'uploads/site/logo/' . $filename;
        }

        $config->updateOrCreate(
            ['id' => $config->id ?? null],
            $data
        );

        return back()->with('success', 'تنظیمات سایت با موفقیت بروزرسانی شد.');
    }
}
