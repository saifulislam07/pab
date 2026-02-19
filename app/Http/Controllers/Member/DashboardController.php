<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_approved_members' => \App\Models\Member::where('status', 'approved')->count(),
            'upcoming_events'        => \App\Models\Event::where('event_date', '>=', now())->count(),
            'total_gallery'          => \App\Models\GalleryItem::count(),
        ];

        $member = auth()->user()->member;

        return view('member.dashboard', compact('stats', 'member'));
    }
}
