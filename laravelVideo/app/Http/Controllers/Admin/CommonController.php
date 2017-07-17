<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CommonController
 *
 * @package App\Http\Controllers\Admin
 */
abstract class CommonController extends Controller
{
    /**
     * CommonController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    /**
     * 成功信息
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message)
    {
        return response()->json(['message' => $message, 'valid' => 1]);
    }

    /**
     * 错误信息
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message)
    {
        return response()->json(['message' => $message, 'valid' => 0]);
    }
}
