<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Sponsor;
use App\Models\Earning;
use App\Models\Program;
use App\Models\ProgramRegistration;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller {
    public function index() {
        // Summary KPIs
        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');

        $stats = [
            'total_members'   => Member::where('status', 'approved')->count(),
            'pending_members' => Member::where('status', 'pending')->count(),
            'total_events'    => Event::count(),
            'total_gallery'   => GalleryItem::count(),
            'total_sponsors'  => Sponsor::count(),
            'total_income'    => $totalIncome,
            'total_expense'   => $totalExpense,
            'net_balance'     => $totalIncome - $totalExpense,
            'total_programs'  => Program::count(),
            'active_programs' => Program::where('is_registration_active', true)->count(),
        ];

        // Recent Activity
        $recent_registrations = ProgramRegistration::with(['program'])
            ->latest()
            ->limit(8)
            ->get();

        $recent_member_requests = Member::where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Chart Data: Last 30 Days Registration Trend
        $chart_data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = ProgramRegistration::whereDate('created_at', $date)->count();
            $chart_data[] = [
                'date'  => Carbon::now()->subDays($i)->format('M d'),
                'count' => $count,
            ];
        }

        return view('dashboard', compact('stats', 'recent_registrations', 'recent_member_requests', 'chart_data'));
    }
}
