<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\material;

use houdunwang\curl\Curl;

/**
 * 临时素材管理
 * Trait Media
 *
 * @package houdunwang\wechat\material
 */
trait Media
{
    /**
     * 上传临时素材
     *
     * @param     $type
     * @param     $file
     *
     * @return mixed
     */
    public function addMedia($type, $file)
    {
        $url = $this->apiUrl
            ."/cgi-bin/media/upload?access_token={$this->accessToken}&type=$type";

        $result = Curl::post($url, $this->getPostMedia($file));

        return $this->get($result);
    }

    /**
     * 下载临时素材
     *
     * @param $mediaId
     *
     * @return bool|string
     */
    public function getMedia($mediaId)
    {
        $url = $this->apiUrl
            ."/cgi-bin/media/get?access_token={$this->accessToken}&media_id={$mediaId}";

        $res = Curl::get($url);

        return $this->get($res);
    }
}