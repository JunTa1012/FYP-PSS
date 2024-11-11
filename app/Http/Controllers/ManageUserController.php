<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    public function showUserList()
    {
        $users = User::all();

        // Get the user's current reward points
        return view('ManageUser.user_list', compact('users'));
    }

    public function addUser()
    {
        return view('ManageUser.add_user_form');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'role' => $request->role,
            // 'password' =>$request->password,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.list');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('ManageUser.edit_user_form', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required',
            'role' => 'required',
        ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'role' => $request->role,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('user.list');
    }

    public function deleteUser($id) {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.list')->with('success', 'User deleted successfully!');
    }
}
