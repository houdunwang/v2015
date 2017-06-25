<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\mail\build;

use houdunwang\config\Config;

/**
 * 邮箱发送
 * Class Base
 *
 * @package houdunwang\mail\build
 */
class Base
{
    public function send($usermail, $username, $title, $body)
    {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->CharSet='utf-8';
        // Specify main and backup SMTP servers
        $mail->Host = Config::get('mail.host');
        // Enable SMTP authentication
        $mail->SMTPAuth = true;
        // SMTP username
        $mail->Username = Config::get('mail.username');
        // SMTP password
        $mail->Password = Config::get('mail.password');
        if (Config::get('mail.ssl')) {
            $mail->SMTPSecure = 'tls';
        }
        $mail->Port = Config::get('mail.port');
        $mail->setFrom(
            Config::get('mail.frommail'),
            Config::get('mail.fromname')
        );
        // Add a recipient
        $mail->addAddress($usermail, $username);
        $mail->Subject = $title;
        $mail->msgHTML($body);

        return $mail->send();
    }
}