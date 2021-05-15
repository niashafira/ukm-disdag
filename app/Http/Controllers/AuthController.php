<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash as Hash;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {

        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        Auth::attempt($data);

        if (Auth::check()) {
            $res['status'] = "S";
            $res['message'] = "Login Success";
        }
        else {
            $res['status'] = "E";
            $res['message'] = "Username atau Password Salah";
        }

        return response()->json($res);

    }

    public function register(Request $request)
    {

        $user = new User();
        $user->username = "admin";
        $user->password = Hash::make("disdag2021");
        $user->nama = "Administrator";
        $user->role = "admin";
        $user->save();

    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }


}
