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

    public function events(\Illuminate\Http\Request $request) {
        $type = $request->query('type', 'current');
        $today = now()->toDateString();

        $query = \App\Models\Event::where('is_active', true);

        if ($type === 'current') {
            $query->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today);
        } elseif ($type === 'past') {
            $query->where('end_date', '<', $today);
        } else {
            // Default: Upcoming
            $query->where('start_date', '>', $today);
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        $bannerAds = \App\Models\Advertisement::active()->where('position', 'banner')->get();
        $sidebarAds = \App\Models\Advertisement::active()->where('position', 'sidebar')->get();

        return view('frontend.events.index', compact('events', 'bannerAds', 'sidebarAds', 'type'));
    }

    public function eventShow($slug) {
        $event = \App\Models\Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $bannerAds = \App\Models\Advertisement::active()->where('position', 'banner')->get();
        $sidebarAds = \App\Models\Advertisement::active()->where('position', 'sidebar')->get();

        return view('frontend.events.show', compact('event', 'bannerAds', 'sidebarAds'));
    }

    public function registration() {
        return view('frontend.registration');
    }

    public function gallery() {
        $categories = \App\Models\Category::withCount('items')->get();
        $totalItems = \App\Models\GalleryItem::count();
        $items = \App\Models\GalleryItem::with('category')->latest()->paginate(12);

        return view('frontend.gallery', compact('items', 'categories', 'totalItems'));
    }

    public function galleryItems(\Illuminate\Http\Request $request) {
        $query = \App\Models\GalleryItem::with('category')->latest();

        if ($request->category && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $items = $query->paginate(12);

        return response()->json([
            'data'         => $items->items(),
            'current_page' => $items->currentPage(),
            'last_page'    => $items->lastPage(),
            'has_more'     => $items->hasMorePages(),
        ]);
    }

    public function contact() {
        return view('frontend.contact');
    }
}
