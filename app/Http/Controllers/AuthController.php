<?php



namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User as User;

use Illuminate\Support\Facades\Log;




class AuthController extends Controller
{
    // Will logout user
    public static function logout(Request $request): RedirectResponse
    {

        auth()->logout();
        Session::flush();
        Auth::guard('web')->logout();
        Auth::logout();
        
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        Session::regenerate();
        
        // return redirect($request::previous());
        return redirect('/');
    }


    // Creates new user and adds ot database
    public static function createUser(Request $request): RedirectResponse
    {

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        //($name, $password, $email)
        // Check if a test user already exists to avoid duplicates
        $testUser = User::where('email', $email)->first();

        $testUserName = User::where('user_name', $name)->first();

        if ((!$testUser) && (!$testUserName)) {
            return User::create([
                'user_name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }
    }




    // Will login user
    public static function loginUser($email, $password)
    {
        // $email = $request->email;
        // $password = $request->password;
        $temp = Auth::attempt(['email' => $email, 'password' => $password]);
        if ($temp) {
            session()->regenerate();
            //return redirect()->intended();
            return redirect('/');
        }

        
        return null;
    }


    // public static function logout(){
    //     Auth::logout();
    //     session()->invalidate();
    //     session()->regenerateToken();
    //     return redirect('/');
    // }

    // Used to check is session is still valid
    public static function checkAuth()
    {
        return Auth::check();
    }
}
