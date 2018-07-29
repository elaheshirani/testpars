<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerifyMail;
use App\User;
use App\Http\Controllers\Controller;
use App\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'birthday' => 'required|date|date_format:Y-m-d',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'family'=> $data['family'],
            'birthday' => $data['birthday'],
            'gender'=> $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $verify_user = VerifyUser::create([
            'user_id' => $user->id,
            'code' => str_random(40)
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    public function verifyUser($code){
        $verifyUser = VerifyUser::where('code',$code)->first();
        if(isset($verifyUser)){
            $user = $verifyUser->user;
            if(!$user->verified){
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = 'Your email is verified .You can now login.';
            }else{
                $status = 'Your email is already verified .You can now login.';
            }
        }else{
            return redirect('/login')->with('warning',"Sorry your email can not be identified.");
        }

        return redirect('/login')->with('status',$status);
    }
}
