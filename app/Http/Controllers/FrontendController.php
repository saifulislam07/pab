<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Member;
use App\Models\ProgramRegistration;
use App\Mail\MemberAutoRegisteredMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        $members = \App\Models\Member::where('status', 'approved')
            ->latest()
            ->get();
        return view('frontend.members', compact('members'));
    }

    public function memberShow($id) {
        $member = \App\Models\Member::where('status', 'approved')
            ->findOrFail($id);
        return view('frontend.member-show', compact('member'));
    }

    public function events(\Illuminate\Http\Request $request) {
        $type = $request->query('type', 'current');
        $search = $request->query('search'); // Get search query
        $today = now()->toDateString();

        $query = \App\Models\Event::where('is_active', true);

        // Apply Search Filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

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

        return view('frontend.events.index', compact('events', 'bannerAds', 'sidebarAds', 'type', 'search'));
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

    public function programs(\Illuminate\Http\Request $request) {
        $search = $request->query('search');
        $today = now()->toDateString();
        $query = \App\Models\Program::where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $programs = $query->latest()->paginate(10)->withQueryString();
        $bannerAds = \App\Models\Advertisement::active()->where('position', 'banner')->get();
        $sidebarAds = \App\Models\Advertisement::active()->where('position', 'sidebar')->get();

        return view('frontend.programs.index', compact('programs', 'bannerAds', 'sidebarAds', 'search'));
    }

    public function programShow($slug) {
        $program = \App\Models\Program::where('slug', $slug)
            ->where('is_active', true)
            ->with(['sponsors', 'registrations' => function($q) {
                $q->latest();
            }])
            ->firstOrFail();

        $bannerAds = \App\Models\Advertisement::active()->where('position', 'banner')->get();
        $sidebarAds = \App\Models\Advertisement::active()->where('position', 'sidebar')->get();

        return view('frontend.programs.show', compact('program', 'bannerAds', 'sidebarAds'));
    }

    public function programRegister(\Illuminate\Http\Request $request, $slug) {
        $program = \App\Models\Program::where('slug', $slug)
            ->where('is_registration_active', true)
            ->where('is_active', true)
            ->firstOrFail();

        // Convert Bengali numbers to English
        $input = $request->all();
        $banglaToEnglishMap = ['০'=>'0','১'=>'1','২'=>'2','৩'=>'3','৪'=>'4','৫'=>'5','৬'=>'6','৭'=>'7','৮'=>'8','৯'=>'9'];
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $input[$key] = strtr($value, $banglaToEnglishMap);
            }
        }
        $request->merge($input);

        $rules = [];
        $messages = [];
        if ($program->registration_fields) {
            foreach ($program->registration_fields as $field) {
                $isObject = is_array($field);
                $label = $isObject ? ($field['name'] ?? '') : $field;
                $type = $isObject ? ($field['type'] ?? 'text') : 'text';
                $required = $isObject ? ($field['required'] ?? true) : true;
                $fieldName = str_replace(' ', '_', strtolower($label));

                $fieldRules = [$required ? 'required' : 'nullable'];
                
                if ($type == 'email') $fieldRules[] = 'email';
                if ($type == 'number') $fieldRules[] = 'numeric';
                if ($type == 'date') $fieldRules[] = 'date';
                if ($type == 'photo') $fieldRules[] = 'image|max:5120';
                if ($type == 'textarea' || $type == 'text') $fieldRules[] = 'string';

                // Check for amount/fee to enforce minimum registration fee
                if (Str::contains($fieldName, ['amount', 'fee', 'টাকা', 'ফি', 'আমাউন্ট'])) {
                    if ($program->registration_fee > 0) {
                        if (!in_array('numeric', $fieldRules)) {
                            $fieldRules[] = 'numeric';
                        }
                        $fieldRules[] = 'min:' . $program->registration_fee;
                        $messages["$fieldName.min"] = "The $label cannot be less than the registration fee of {$program->registration_fee}.";
                    }
                }

                // Check for transaction ID to enforce english alphanumeric
                if (Str::contains($fieldName, ['transaction', 'trx', 'ট্রানজ্যাকশন', 'ট্রানজেকশন'])) {
                    $fieldRules[] = 'regex:/^[a-zA-Z0-9]+$/';
                    $messages["$fieldName.regex"] = "The $label must contain only English letters and numbers.";
                }

                $rules[$fieldName] = implode('|', $fieldRules);
            }
        }

        $validatedData = $request->validate($rules, $messages);

        // Extract Name, Email, and Mobile for auto-registration
        $regName = ProgramRegistration::extractField($validatedData, 'name') ?? 'Guest User';
        $regEmail = ProgramRegistration::extractField($validatedData, 'email');
        $regMobile = ProgramRegistration::extractField($validatedData, 'mobile');

        $userId = auth()->id();

        // Auto-registration logic if not logged in
        if (!$userId && ($regEmail || $regMobile)) {
            // Check if user exists by email
            $existingUser = null;
            if ($regEmail) {
                $existingUser = User::where('email', $regEmail)->first();
            }

            // Check if member exists by mobile
            if (!$existingUser && $regMobile) {
                $existingMember = Member::where('mobile', $regMobile)->first();
                if ($existingMember) {
                    $existingUser = User::find($existingMember->user_id);
                }
            }

            if ($existingUser) {
                $userId = $existingUser->id;
            } else {
                // Create new user
                $password = $regMobile ?? Str::random(10);
                $newUser = User::create([
                    'name'     => $regName,
                    'email'    => $regEmail ?? ($regMobile . '@pab.org.bd'), // Fallback if no email
                    'password' => Hash::make($password),
                    'role'     => 'member',
                ]);

                $newUser->assignRole('member');

                Member::create([
                    'user_id' => $newUser->id,
                    'name'    => $newUser->name,
                    'email'   => $newUser->email,
                    'mobile'  => $regMobile,
                    'role'    => 'Standard Member',
                    'status'  => 'pending',
                ]);

                $userId = $newUser->id;

                // Send email if email is provided
                if ($regEmail) {
                    try {
                        Mail::to($regEmail)->send(new MemberAutoRegisteredMail($newUser, $password));
                    } catch (\Exception $e) {
                        \Log::error('Auto-registration mail failed: ' . $e->getMessage());
                    }
                }

                // Log the user in
                Auth::login($newUser);
            }
        }

        // Handle file uploads
        if ($program->registration_fields) {
            foreach ($program->registration_fields as $field) {
                $isObject = is_array($field);
                $label = $isObject ? ($field['name'] ?? '') : $field;
                $type = $isObject ? ($field['type'] ?? 'text') : 'text';
                $fieldName = str_replace(' ', '_', strtolower($label));

                if ($type == 'photo' && $request->hasFile($fieldName)) {
                    $image = $request->file($fieldName);
                    $imageName = 'reg_' . time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('programe'), $imageName);
                    $validatedData[$fieldName] = $imageName;
                }
            }
        }

        // Extract potential transaction ID for the top-level column
        $transactionId = null;
        foreach ($validatedData as $key => $value) {
            if (Str::contains(strtolower($key), ['transaction', 'trx', 'ট্রানজ্যাকশন', 'ট্রানজেকশন'])) {
                $transactionId = $value;
                break;
            }
        }

        ProgramRegistration::create([
            'program_id'        => $program->id,
            'user_id'           => $userId,
            'registration_data' => $validatedData,
            'status'            => 'pending',
            'payment_status'    => $program->registration_fee > 0 ? 'unpaid' : 'paid',
            'transaction_id'    => $transactionId,
        ]);

        return redirect()->back()->with('success', 'Registration submitted successfully!');
    }

    public function contact() {
        return view('frontend.contact');
    }
}
