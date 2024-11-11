<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RecycleActivity;
use App\Models\RedeemReward;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();

        if (Auth()->user()->hasRole('admin')) {
            // Admin sees all recycle activities
            $totalRecycleActivities = RecycleActivity::count();
            $totalRewards = RedeemReward::count();
            $recycleActivities = RecycleActivity::all();
        } else {
            // Regular user sees only their own recycle activities
            $totalRecycleActivities = RecycleActivity::where('user_id', Auth::id())->count();
            $totalRewards = RedeemReward::where('user_id', Auth::id())->count();
            $recycleActivities = RecycleActivity::where('user_id', Auth::id())->get();
        }

        $chartProducts = Product::select('product_name', 'product_quantity')->get();
        
        $chartRecycleActivities = RecycleActivity::select('recycle_status', \DB::raw('count(*) as total'))
        ->groupBy('recycle_status')
        ->get();
        
        return view('dashboard', compact('totalProducts','totalRecycleActivities', 'chartProducts', 'chartRecycleActivities', 'totalRewards'));
    }
}
