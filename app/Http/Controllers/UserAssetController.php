<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAssetController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $activeAssignments = $user->activeAssets()
            ->with('asset')
            ->latest()
            ->get();

        $allAssignments = $user->assetAssignments()
            ->with('asset')
            ->latest()
            ->paginate(10);

        return view('user.assets', compact('activeAssignments', 'allAssignments'));
    }
}
