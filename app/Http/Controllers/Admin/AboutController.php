<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller {
    public function edit() {
        $about = \App\Models\About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request) {
        $about = \App\Models\About::first();

        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'subtitle'        => 'nullable|string|max:255',
            'description'     => 'required|string',
            'our_story'       => 'required|string',
            'mission'         => 'nullable|string',
            'stats_years'     => 'required|string',
            'stats_members'   => 'required|string',
            'stats_workshops' => 'required|string',
            'stats_awards'    => 'required|string',
            'image_main'      => 'nullable|image',
            'image_secondary' => 'nullable|image',
        ]);

        if ($request->hasFile('image_main')) {
            $data['image_main'] = $request->file('image_main')->store('about', 'public');
        }

        if ($request->hasFile('image_secondary')) {
            $data['image_secondary'] = $request->file('image_secondary')->store('about', 'public');
        }

        if ($about) {
            $about->update($data);
        } else {
            \App\Models\About::create($data);
        }

        return redirect()->back()->with('success', 'About section updated successfully.');
    }
}
