<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
      public function index(){
    $users = User::all();
    return view('admin.users' ,compact('users'));
  }

  public function edit(User $user){
    return view('admin.edit-user', compact('user'));
  }

  public function update(Request $request , User  $user){
    $user->role = $request->role;
    $user->save();
    return redirect('admin/users')->with('success', 'Utilisateur mis à jour avec succès.');
  }

  public function delete(User $user){
    $user->delete();
    return redirect('admin/users')->with('success', 'Utilisateur supprimé avec succès.');
  }

}
