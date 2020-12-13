<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * -----------------------------------------
     * API Authentikasi Controller
     * -----------------------------------------
     *
     * Controller ini berfungsi untuk authentikasi melalui API seperti:
     * - Login
     * - Register
     * - Verifikasi Email Pendaftar
     * - Re-Send Verifikasi Email Pendaftar
     */


    /**
     * Login Function.
     *
     * @param  \Illuminate\Http\Request $request
     * @param String $email
     * @param String $password
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Sign In",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Login Credential",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="johndoe@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="pass1234"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function login(Request $request)
    {
        // validate input request
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string|min:3|max:255'
        ]);

        // get data form input
        $getInput = $request->only(['name', 'email', 'password']);

        // Validate Email and Password Input
        if (Auth::attempt([
            'email'     => $getInput['email'],
            'password'  => $getInput['password']
        ])) {

            // get user detail
            $user = Auth::user();

            // array response
            $response = [
                'code'      => 200,
                'success'   => true,
                'data'      => [
                    // generate token
                    'token' => $user->createToken('Api')->accessToken,
                ]
            ];

            // return json response
            return response()->json($response, $response['code']);
        } else {
            // return error validate
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Login Function.
     *
     * @param  \Illuminate\Http\Request $request
     * @param String $name Nama Akun
     * @param String $email Alamat Email
     * @param String $password Kata Sandi Akun
     * @param String $confirm_password Konfirmasi Kata Sandi Akun
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register Account",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Register Account",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="johndoe@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="pass1234"
     *                 ),
     *                 @OA\Property(
     *                     property="confirm_password",
     *                     type="string",
     *                     example="pass1234"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function register(Request $request)
    {
        // validate form input
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|unique:users|max:255',
            'password'          => 'required|string|max:255',
            'confirm_password'  => 'required|string|max:255|same:password',
        ]);

        // get data form input
        $getInput = $request->only(['name', 'email', 'password']);

        // save user to database
        $user = User::create([
            'name'      => $getInput['name'],
            'email'     => $getInput['email'],
            'password'  => Hash::make($getInput['password']),
            'type'      => 'asessi',
            'status'    => 'inactive',
            'is_active' => false,
        ]);

        // Generate User Token
        $token = $user->createToken('Api')->accessToken;

        // Check if user is verified or not
        // If not, send email verification
        if (!$user->hasVerifiedEmail()) {
            // Send Email Verification to User
            Mail::to($user->email)->queue(new EmailVerification($token, $user));
        }

        // array response
        $response = [
            'code'      => 200,
            'success'   => true,
            'data'      => [
                'name'  => $user->name,
                'email' => $user->email,
                'token' => $token,
            ]
        ];

        // return json response
        return response()->json($response, $response['code']);
    }
}
