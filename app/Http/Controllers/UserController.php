<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

    function LoginPage() {
        return view('pages.auth.login-page');
    }

    function RegistrationPage() {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage() {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage() {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage() {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage() {
        return view('pages.dashboard.profile-page');
    }

    public function register(Request $request) {
        try {
            $data = $request->validate([
                'firstName' => 'required | string',
                'lastName'  => 'required | string',
                'email'     => 'required | email | unique:users,email',
                'mobile'    => 'required | string',
                'password'  => 'required',
            ]);
            User::create($data);
            return response()->json([
                'status'  => 'success',
                'message' => 'User created successfully']

            );
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Email is already taken']

            );
        }
    }

    public function login(Request $request) {

        $request->validate([
            'email'    => 'required | email',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->select('id')->first();
        $password = User::where('email', $request->email)->first();

        if ($user !== null) {

            if (Hash::check($request->password, $password->password)) {
                $token = JWTToken::createToken($request->email, $user->id);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'User logged in successfully',

                ]

                )->cookie('token', $token, 60 * 24 * 30);
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Password is incorrect']

                );
            }

        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Email is invalid']

            );
        }
    }

    public function sendOTPCode(Request $request) {
        $email = $request->email;
        $otp = rand(1000, 9999);
        $user = User::where('email', $email)->first();

        if (!empty($user)) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->first()->update(['otp' => $otp]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Otp send successfully',
                'otp'     => $otp,

            ]

            );
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Email is invalid',

            ]

            );
        }
    }

    public function verifyOTPCode(Request $request) {
        $email = $request->email;
        $otp = $request->otp;
        $count = User::where('email', $email)->where('otp', $otp)->count();
        $userID = User::where('email', $email)->select('id')->first();

        if ($count == 1) {

            User::where('otp', $otp)->update(['otp' => '0']);
            $token = JWTToken::createToken($request->email, $userID->id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Otp verified successfully',

            ]

            )->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Otp do not match',

            ]

            );
        }

    }

    public function resetPassword(Request $request) {

        try {
            $email = $request->header('email');
            $password = Hash::make($request->password);
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Password reset successfully',

            ]

            );
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Something went wrong',

            ]

            );
        }

    }

    public function logout() {
        return redirect('/userLogin')->cookie('token', '', -1);
    }

    public function getUserProfile(Request $request) {
        $email = $request->header('email');
        $user = User::where('email', $email)->first();
        return response()->json([
            'status'  => 'success',
            'message' => 'Request successfully',
            'data'    => $user,

        ]
            , 200
        );
    }

    public function updateUserProfile(Request $request) {
        try {
            $email = $request->header('email');
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $mobile = $request->mobile;
            $password = $request->password;

            User::where('email', $email)->update([
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'mobile'    => $mobile,
                'password'  => $password,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'User updated successfully',

            ]

            );
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Something went wrong',

            ]

            );
        }
    }

}
