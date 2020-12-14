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
 *      url="https://admin.lsp-mpsdm.com",
 *      description="Production API Server"
 *  )
 *
 *  @OA\Server(
 *      url="https://admin-staging.lsp-mpsdm.com",
 *      description="Staging API Server"
 *  )
 *
 *  @OA\Server(
 *      url="http://127.0.0.1:8000",
 *      description="Local Development API Server"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
