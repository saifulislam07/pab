<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller {
    public function edit() {
        $setting = Setting::first();
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request) {
        $setting = Setting::first();

        $data = $request->validate([
            'site_name'      => 'required|string|max:255',
            'site_title'     => 'required|string|max:255',
            'footer_text'    => 'nullable|string',
            'contact_email'  => 'nullable|email',
            'contact_phone'  => 'nullable|string',
            'address'        => 'nullable|string',
            'logo'           => 'nullable|image|max:2048',
            'favicon'        => 'nullable|image|max:1024',
            'facebook_link'  => 'nullable|url',
            'twitter_link'   => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'linkedin_link'  => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }
}
