<?php namespace hdphp\weixin\build;
use hdphp\weixin\Weixin;
//自定义菜单
class Button extends Weixin
{
    //创建菜单
    public function createButton($button)
    {
        $url = $this->apiUrl . '/cgi-bin/menu/create?access_token=' . $this->getAccessToken();

        $content = Curl::post($url, urldecode(json_encode($this->urlencodeArray($button))));

        $result = json_decode($content, true);

        return $this->get($result);
    }

    //创建个性化菜单
    public function createAddconditionalButton($button)
    {
        $url = $this->apiUrl . '/cgi-bin/menu/addconditional?access_token=' . $this->getAccessToken();

        $content = Curl::post($url, urldecode(json_encode($this->urlencodeArray($button))));

        $result = json_decode($content, true);

        return $this->get($result);
    }

    //查询微信服务器上菜单
    public function queryButton()
    {
        $url     = $this->apiUrl . '/cgi-bin/menu/get?access_token=' . $this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }

    //删除菜单
    public function delButton()
    {
        $url     = $this->apiUrl . '/cgi-bin/menu/delete?access_token=' . $this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }
}