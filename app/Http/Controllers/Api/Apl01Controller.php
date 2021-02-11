<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UserAsesi;
use Illuminate\Http\Request;

class Apl01Controller extends Controller
{
    /**
     * Apply Middleware Verified in All Function
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     *
     *
     *
     * * @OA\Get(
     *   path="/api/apl01",
     *   tags={"APL01"},
     *   summary="Asesi APL01 Data",
     *   security={{"passport":{}}},
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function index(Request $request)
    {
        // get user login
        $user = $request->user();

        // get data APL01
        return UserAsesi::with('asesicustomdata')
                ->where('user_id', $user->id)
                ->firstOrFail();

    }
}
