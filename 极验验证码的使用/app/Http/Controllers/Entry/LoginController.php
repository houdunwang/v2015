<?php

namespace App\Http\Controllers\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\component\GeetestController;

define("CAPTCHA_ID", "9e298cd11c70c00ac09bd240d7028dd3");
define("PRIVATE_KEY", "f4cfb51cdb68a4e0c769d230638758c7");

class LoginController extends Controller
{
    public function loginform(){
        return view('login');
    }

    public function login(){
        //在这个方法中,需要判断用户名是否存在,存在的话密码是否正确
        return 'check login';
    }
    /**
     * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
     * @author Tanxu
     */
    public function StartCaptchaServlet(){

//error_reporting(0);
//        require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
//        require_once dirname(dirname(__FILE__)) . '/config/config.php';
        $GtSdk = new GeetestController(CAPTCHA_ID, PRIVATE_KEY);
        session_start();

        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );

        $status = $GtSdk->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $data['user_id'];
        echo $GtSdk->get_response_str();
    }
}
