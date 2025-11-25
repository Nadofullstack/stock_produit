<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function admin()
    {
        return view('admin.dashboard');
    }
//j'ai un problème de redirect et boucle infini qui coup mon serve si j'appu
    public function manager()
    {
        return view('manager.dashboard');
    }

    public function caisse()
    {
        return view('caisse.dashboard');
    }
}




   
   
 
// class PasswordSetupController extends Controller
// {
//     public function showSetupForm(User $user)
//     {
//         return view('auth.setup-password', compact('user'));
//     }
 
//     public function storePassword(Request $request, User $user)
//     {
//         $request->validate([
//             'password' => 'required|min:6|confirmed'
//         ]);
 
//         $user->update([
//             'password' => Hash::make($request->password)
//         ]);
 
//         return redirect()->route('login')->with('success', 'Mot de passe créé avec succès !');
//     }
// }
 
 
