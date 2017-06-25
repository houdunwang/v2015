<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests;

use houdunwang\wechat\WeChat;

/**
 * 素材测试
 * Class MaterialTest
 *
 * @package tests
 */
class MaterialTest extends Common
{
    /**
     * 临时素材
     */
    public function test_media()
    {
        //上传临时素材
        $res           = WeChat::instance('material')
            ->addMedia('image', 'tests/images/user.jpg');
        $this->mediaId = $res['media_id'];
        $this->assertTrue(isset($res['media_id']));

        //下载临时素材
        $res = WeChat::instance('material')->getMedia($this->mediaId);
        $this->assertTrue(! isset($res['errcode']));
    }

    /**
     * 永久素材测试
     */
    public function test_Material()
    {
        //上传永久素材
        $instance = WeChat::instance('material');
        $material = $instance->addMaterial('image', 'tests/images/user.jpg');
        $this->assertTrue(isset($material['media_id']));

        //获取永久素材
        $res = $instance->getMaterial($material['media_id']);
        $this->assertTrue(! isset($res['errcode']));

        //删除永久素材
        $res = $instance->delMaterial($material['media_id']);
        $this->assertTrue($res['errcode'] == 0);
    }

    /*
     * 图文素材测试
     */
    public function test_news()
    {
        //上传永久素材
        $instance = WeChat::instance('material');
        $image    = $instance->addMaterial('image', 'tests/images/user.jpg');
        $this->assertTrue(isset($image['media_id']));
        $articles = [
            'articles' => [
                [
                    'title'              => '后盾人',
                    //图文消息的封面图片素材id（必须是永久mediaID）
                    'thumb_media_id'     => $image['media_id'],
                    //作者
                    'author'             => '后盾网',
                    //图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空
                    'digest'             => '摘要信息...',
                    //1 显示封面 0 不显示
                    'show_cover_pic'     => 1,
                    //图文内容，必须少于2万字符
                    'content'            => '图文内容...',
                    //图文消息的原文地址，即点击“阅读原文”后的URL
                    'content_source_url' => 'http://houdunwang.com',
                ],
            ],
        ];
        //添加图文,返回为新增的图文消息素材的media_id
        $instance = WeChat::instance('material');
        $result   = $instance->addNews($articles);
        echo $result['media_id'];
        $this->assertTrue(isset($result['media_id']));

        //修改图文消息
        $article = [
            //要修改的图文消息的id
            "media_id" => $result['media_id'],
            //要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
            "index"    => 0,
            'articles' => [
                'title'              => '后盾人 人人做后盾',
                //图文消息的封面图片素材id（必须是永久mediaID）
                'thumb_media_id'     => $image['media_id'],
                //作者
                'author'             => '后盾网',
                //图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空
                'digest'             => '摘要信息...',
                //1 显示封面 0 不显示
                'show_cover_pic'     => 1,
                //图文内容，必须少于2万字符
                'content'            => '这是修改接口图文内容...',
                //图文消息的原文地址，即点击“阅读原文”后的URL
                'content_source_url' => 'http://www.houdunwang.com',
            ],
        ];
        $result  = WeChat::instance('material')->editNews($article);
        $this->assertEquals('ok', $result['errmsg']);
    }

    //获取素材总数
    public function test_count()
    {
        $res = WeChat::instance('material')->total();
        $this->assertTrue(isset($res['image_count']));
    }

    public function test_lists()
    {
        $param = [
            //素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
            "type"   => 'image',
            //从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
            "offset" => 0,
            //返回素材的数量，取值在1到20之间
            "count"  => 10,
        ];
        $res   = WeChat::instance('material')->lists($param);
        $this->assertTrue(isset($res['total_count']));
    }
}