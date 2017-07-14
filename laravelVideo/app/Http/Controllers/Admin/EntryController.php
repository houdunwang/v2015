<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

/**
 * Class EntryController
 *
 * @package App\Http\Controllers\Admin
 */
class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth')->except(['loginForm', 'login']);
    }

    /**
     * @return string
     */
    public function index()
    {
        return view('admin.entry.index');
    }

    /**
     * 登录视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginForm()
    {
        return view('admin.entry.login');
    }

    /**
     * 登录处理
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $status = Auth::guard('admin')->attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);
        if ($status) {
            //登录成功
            return redirect('/admin/index');
        }

        return redirect('/admin/login')->with('error', '用户名或密码错误');
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }
}
