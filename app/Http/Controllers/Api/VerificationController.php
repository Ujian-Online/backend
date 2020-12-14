<?php

namespace App\Http\Controllers\Api;

use App\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /**
     * Verifikasi Email User
     *
     * @param  \Illuminate\Http\Request $request
     * @param String $hash Hash dari Email
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Post(
     *     path="/api/email/verify",
     *     tags={"Authentication"},
     *     summary="Email Verification",
     *     security={{"passport":{}}},
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function verify(Request $request)
    {
        try {
            // check if email has been verified or not
            if ($request->user()->hasVerifiedEmail()) {
                throw new Exception('Email sudah di verifikasi.');
            }

            // get user login
            $user = $request->user();

            // mark user verified
            $user->markEmailAsVerified();

            // set status to active
            $user->status = 'active';
            $user->update();

            // return error validate
            return response()->json([
                'code'      => 200,
                'success'   => true,
            ], 200);
        } catch (Exception $e) {
            // return error validate
            return response()->json([
                'code'      => 400,
                'success'   => false,
                'error'     => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Kirim Ulang Verifikasi Email User
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/email/resend",
     *     tags={"Authentication"},
     *     summary="Resend Email Verification",
     *     security={{"passport":{}}},
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function resend(Request $request)
    {
        try {
            // get user login
            $user = $request->user();

            // check if email has been verified or not
            if ($user->hasVerifiedEmail()) {
                throw new Exception('Email sudah di verifikasi.');
            }

            // Generate User Token
            $token = $user->createToken('Api')->accessToken;

            // Check if user is verified or not
            // If not, send email verification
            if (!$user->hasVerifiedEmail()) {
                // Send Email Verification to User
                Mail::to($user->email)->queue(new EmailVerification($token, $user));
            }

            // return error validate
            return response()->json([
                'code'      => 200,
                'success'   => true,
            ], 200);
        } catch (Exception $e) {
            // return error validate
            return response()->json([
                'code'      => 400,
                'success'   => false,
                'error'     => $e->getMessage()
            ], 400);
        }
    }
}
