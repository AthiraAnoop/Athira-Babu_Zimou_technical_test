<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Package;
use App\Models\Store;
use App\Models\Client;
use Hash;

class AuthController extends Controller
{
    public function index()

    {

        return view('auth.login');
    }

    public function registration()

    {

        return view('auth.register');
    }

    public function postLogin(Request $request)

    {

        $request->validate([

            'email' => 'required',

            'password' => 'required',

        ]);



        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard')

                ->withSuccess('You have Successfully loggedin');
        }



        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function postRegistration(Request $request)

    {

        $request->validate([

            'username' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

        ]);

        $data = $request->all();
        $user = User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'password' => Hash::make($data['password'])

        ]);

        if ($user) {
            Auth::login($user);
            return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
        } else {
            return redirect("login")->withFail('Something went wrong please try again');
        }
    }


    public function dashboard()

    {

        if (Auth::check()) {


            $packages = Package::with('store', 'client')->where('status','Pending')->count();
            $stores = Store::where('store_status', 1)->count();
            $users = Client::where('client_status', 1)->count();
            return view('dashboard',compact('packages', 'stores', 'users'));
        }



        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data)

    {

        return User::create([

            'name' => $data['name'],

            'email' => $data['email'],

            'password' => Hash::make($data['password'])

        ]);
    }

    public function logout()
    {

        Session::flush();

        Auth::logout();



        return Redirect('login');
    }
}
