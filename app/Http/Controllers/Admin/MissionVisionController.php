<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MissionVision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MissionVisionController extends Controller {
    public function edit() {
        $content = MissionVision::first();
        return view('admin.mission-vision.edit', compact('content'));
    }

    public function update(Request $request) {
        $content = MissionVision::first();

        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'subtitle'            => 'nullable|string',
            'mission_title'       => 'required|string|max:255',
            'mission_description' => 'nullable|string',
            'mission_points'      => 'nullable|array',
            'mission_image'       => 'nullable|image|max:2048',
            'vision_title'        => 'required|string|max:255',
            'vision_description'  => 'nullable|string',
            'vision_points'       => 'nullable|array',
            'vision_image'        => 'nullable|image|max:2048',
            'core_values'         => 'nullable|array',
        ]);

        if ($request->hasFile('mission_image')) {
            if ($content->mission_image && ! Str::startsWith($content->mission_image, 'http')) {
                Storage::disk('public')->delete($content->mission_image);
            }
            $data['mission_image'] = $request->file('mission_image')->store('mission-vision', 'public');
        }

        if ($request->hasFile('vision_image')) {
            if ($content->vision_image && ! Str::startsWith($content->vision_image, 'http')) {
                Storage::disk('public')->delete($content->vision_image);
            }
            $data['vision_image'] = $request->file('vision_image')->store('mission-vision', 'public');
        }

        // Filter null points
        $data['mission_points'] = array_filter($request->mission_points ?? [], fn($p) => ! is_null($p));
        $data['vision_points'] = array_filter($request->vision_points ?? [], fn($p) => ! is_null($p));

        if ($content) {
            $content->update($data);
        } else {
            MissionVision::create($data);
        }

        return redirect()->back()->with('success', 'Mission & Vision updated successfully.');
    }
}
