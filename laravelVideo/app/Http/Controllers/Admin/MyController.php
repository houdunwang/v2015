<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MyController extends Controller
{
    public function passwordForm()
    {
        return view('admin.my.passwordForm');
    }

    public function changePassword(AdminPost $request)
    {
        $model           = Auth::guard('admin')->user();
        $model->password = bcrypt($request['password']);
        $model->save();
        flash('密码修改成功')->overlay();

        return redirect()->back();
    }
}
