<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Order Index Function
     *
     * @param Request $request
     *
     * @return LengthAwarePaginator
     *
     * * @OA\Get(
     *   path="/api/order",
     *   tags={"Order"},
     *   summary="Order Index",
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

        // get order detail
        return Order::with('sertifikasi')
            ->leftjoin('user_asesis', 'user_asesis.id', '=', 'orders.asesi_id')
            ->leftjoin('users', 'users.id', '=', 'user_asesis.user_id')
            ->select('orders.*')
            ->where('users.id', $user->id)
            ->paginate(10);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder
     *
     * @OA\Get(
     *   path="/api/order/{id}",
     *   tags={"Order"},
     *   summary="Order Detail by ID",
     *   security={{"passport":{}}},
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="Order id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function show(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        // get order detail by ID
        return Order::with(['sertifikasi', 'tuk', 'asesi'])
            ->leftjoin('user_asesis', 'user_asesis.id', '=', 'orders.asesi_id')
            ->leftjoin('users', 'users.id', '=', 'user_asesis.user_id')
            ->select('orders.*')
            ->where('users.id', $user->id)
            ->where('orders.id', $id)
            ->firstOrFail();
    }
}
