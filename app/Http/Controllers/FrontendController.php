<?php

namespace App\Http\Controllers;

class FrontendController extends Controller {
    public function index() {
        return view('frontend.home');
    }

    public function about() {
        return view('frontend.about');
    }

    public function missionVision() {
        return view('frontend.mission-vision');
    }

    public function team() {
        return view('frontend.team');
    }

    public function members() {
        $members = \App\Models\Member::all();
        return view('frontend.members', compact('members'));
    }

    public function registration() {
        return view('frontend.registration');
    }

    public function gallery() {
        $items = \App\Models\GalleryItem::all();
        $categories = \App\Models\GalleryItem::select('category')->distinct()->pluck('category');
        return view('frontend.gallery', compact('items', 'categories'));
    }

    public function contact() {
        return view('frontend.contact');
    }
}
