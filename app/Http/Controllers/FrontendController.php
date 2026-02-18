<?php

namespace App\Http\Controllers;

class FrontendController extends Controller {
    public function index() {
        $sliders = \App\Models\Slider::where('is_active', true)->orderBy('order')->get();
        $mission = \App\Models\MissionVision::first();
        $about = \App\Models\About::first();
        $sponsors = \App\Models\Sponsor::where('is_active', true)->orderBy('order')->get();
        $latest_works = \App\Models\GalleryItem::latest()->take(3)->get();
        return view('frontend.home', [
            'sliders'      => $sliders,
            'mission'      => $mission,
            'about'        => $about,
            'sponsors'     => $sponsors,
            'latest_works' => $latest_works,
        ]);
    }

    public function about() {
        $about = \App\Models\About::first();
        return view('frontend.about', compact('about'));
    }

    public function missionVision() {
        $content = \App\Models\MissionVision::first();
        return view('frontend.mission-vision', compact('content'));
    }

    public function team() {
        $members = \App\Models\TeamMember::where('is_active', true)->orderBy('order')->get();
        return view('frontend.team', compact('members'));
    }

    public function members() {
        $members = \App\Models\Member::where('status', 'approved')->latest()->get();
        return view('frontend.members', compact('members'));
    }

    public function events() {
        $events = \App\Models\Event::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now()->toDateString());
            })
            ->latest()
            ->paginate(9);
        return view('frontend.events.index', compact('events'));
    }

    public function eventShow($slug) {
        $event = \App\Models\Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        return view('frontend.events.show', compact('event'));
    }

    public function registration() {
        return view('frontend.registration');
    }

    public function gallery() {
        $items = \App\Models\GalleryItem::with('category')->get();
        $categories = \App\Models\Category::all();
        return view('frontend.gallery', compact('items', 'categories'));
    }

    public function contact() {
        return view('frontend.contact');
    }
}
