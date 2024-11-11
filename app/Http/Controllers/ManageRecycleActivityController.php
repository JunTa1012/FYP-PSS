<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecycleActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageRecycleActivityController extends Controller
{
    //

    public function showRecycleActivityList()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $recycleActivities = RecycleActivity::all();
        } else {
            $recycleActivities = RecycleActivity::where('user_id', $user->id)->get();
        }

        return view('ManageRecycleActivity.recycle_activity_list', compact('recycleActivities'));
    }

    public function viewRecycleActivity($id)
    {
        $recycleActivity = RecycleActivity::findOrFail($id);
        $users = User::all();
        return view('ManageRecycleActivity.view_recycle_activity_form', compact('recycleActivity', 'users'));
    }    

    public function addRecycleActivity()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $users = User::all();
            $recycleStatus = ['Received','Rejected','Completed'];
        } else {
            $users = User::where('id', $user->id)->get();
            $recycleStatus = ['Submitted'];
        }
        return view('ManageRecycleActivity.add_recycle_activity_form', compact('users', 'recycleStatus'));
    }

    
    public function createRecycleActivity(Request $request)
    {
        $request->validate([
            'recycle_datetime' => 'required',
            'recycle_weight' => 'required',
            'recycle_status' => 'required',
            'recycle_category' => 'required',
            'recycle_comment' => 'required',
            'recycle_rate' => 'required',
            'reward_point_earned',
            'user_id' => 'exists:users,id',
        ]);
    
        $data = $request->all();
        $data['recycle_price'] = $data['recycle_weight'] * $data['recycle_rate'];
        $data['reward_point_earned'] = round($data['recycle_price']);

        $recycleActivity = RecycleActivity::create($data);

        // Update the user's total reward points if the recycle status is completed
        if ($data['recycle_status'] == 'Completed') {
            // Update the user's total reward points
            $user = User::find($data['user_id']);
            $user->current_reward_points += $data['reward_point_earned'];
            $user->save();
        }

        return redirect()->route('recycle.activity.list');
    }

    public function editRecycleActivity($id)
    {
        $recycleActivity = RecycleActivity::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'admin') {
            $users = User::all();
            $recycleStatus = ['Received','Rejected','Completed'];
        } else {
            $users = User::where('id', $user->id)->get();
            $recycleStatus = ['Submitted'];
        }

        return view('ManageRecycleActivity.edit_recycle_activity_form', compact('recycleActivity', 'users', 'recycleStatus'));
    }

    public function updateRecycleActivity(Request $request, $id)
    {
        $recycleActivity = RecycleActivity::findOrFail($id);
        $request->validate([
            'recycle_datetime' => 'required',
            'recycle_weight' => 'required',
            'recycle_status' => 'required',
            'recycle_total_price',
            'recycle_category' => 'required',
            'recycle_comment' => 'required',
            'user_id' => 'exists:users,id',
        ]);
    
        // Prepare data for updating
        $data = $request->all();
        $data['recycle_price'] = $data['recycle_weight'] * $data['recycle_rate'];
        $data['reward_point_earned'] = round($data['recycle_price']);

        // Update the recycle activity
        $recycleActivity->update($data);

        // Check if the recycle status is Completed
        if ($data['recycle_status'] == 'Completed') {
            // Update the user's total reward points
            $user = User::find($data['user_id']);
            $user->current_reward_points += $data['reward_point_earned'];
            $user->save();
        }
    
        return redirect()->route('recycle.activity.list');
    }

    public function deleteRecycleActivity($id) {
        $recycleActivity = RecycleActivity::find($id);
        $recycleActivity->delete();
        return redirect()->route('recycle.activity.list')->with('success', 'Recycle Activity deleted successfully!');
    }

    public function showUser()
    {
        $user_id = Auth::id();
        $recycleActivity = RecycleActivity::where('user_id', $user_id)->get();

        return view('ManageRecycleActivity.user_recycle_activities', compact('recycleActivity'));
    }
}
