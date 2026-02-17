<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'available_assets' => Asset::where('status', 'available')->count(),
            'assigned_assets' => Asset::where('status', 'assigned')->count(),
            'total_users' => User::where('is_admin', false)->count(),
        ];

        $recentAssignments = AssetAssignment::with(['asset', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAssignments'));
    }

    public function users()
    {
        $users = User::withCount(['assetAssignments', 'activeAssets'])
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function assignments()
    {
        $assignments = AssetAssignment::with(['asset', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.assignments', compact('assignments'));
    }
}
