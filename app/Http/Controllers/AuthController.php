<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
      public function register(){
        return view("admin.register");
      }

      public function login(){
        
        return view("auth.login");
      }

      public function create(Request $request){
      $this->validator($request->all());
      User::create([
        'name'=>$request['name'],
        'email'=>$request['email'],
       'password'=>bcrypt($request['password']),

      ]);

          $user = User::where('email',$request['email'])->firstOrFail();
        Auth::login($user);
        session()->flash('success_message', 'Votre compte a bien été créé');
        return redirect('/');
      }

      public function store(Request $request){
    $validateUser =  $request->validate([
        '_token'=>'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:manager,caisse'
        ]);

        User::create($validateUser);
        return redirect()->route("admin.users")->with("success","Utilisateur crée avec succès");
      }

            protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);
    }

 public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->with('error', 'Mot de passe incorrect')->withInput();
    }

    $request->session()->regenerate();
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.users');
    }
    if ($user->isManager()) {
        return redirect()->route('manager.dashboard');
    }
    return redirect()->route('caisse.dashboard');
}


    public function adminDashboard(){
        return view('admin.dashboard');
    }
    public function managerDashboard(){
        return view('manager.dashboard');
    }
    public function caisseDashboard(){
        return view('caisse.dashboard');
    }


 public function loginForm(Request $request)
{
    // Validation email
    $validator = Validator::make($request->all(), [
        'email' => 'required|email'
    ]);
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Vérification utilisateur
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->with('error', 'Email introuvable');
    }

    // Si pas encore de mot de passe → setup
    if (is_null($user->password) || $user->password === '') {
        return redirect()->route('password.set', ['email' => $user->email]);
    }

    // Sinon afficher la vue login-password
    return view('auth.login_password', compact('user'));
}


   
   
   public function showSetPasswordForm(){
    return view('auth.email');
   }

   public function storeEmail(Request $request, User $user){

       $request->validate(['email' => 'required|email']);
       $user = User::where('email', $request->email)->first();
      
 
        if (!$user) {
            return back()->withErrors(['email' => 'Email introuvable']);
        }
 
        // Email trouvé mais mot de passe pas encore créé
        if (!$user->password) {
            return view('auth.set_password',compact('user'));
        } else {
            return back()->with('message', 'Votre compte a déjà un mot de passe.');
        }
   }

    public function storePassword(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur introuvable']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        }
        if ($user->isCaisse()) {
            return redirect()->route('caisse.dashboard');
        }

        return redirect()->route('ventes.index');
    }
   



       public function destroy(user $user)
    {
        //
    }

       public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
