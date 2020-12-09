<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  @OA\Info(
 *      title="API Documentation",
 *      version="0.1"
 *  )
 *
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Production API Server"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
