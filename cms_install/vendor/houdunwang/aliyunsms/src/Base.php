<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\aliyunsms;

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;
use houdunwang\config\Config;

class Base
{
    public function send(array $data)
    {
        /**
         * Step 1. 初始化Client
         */
        $this->endPoint  = Config::get('aliyunsms.endPoint');
        $this->accessId  = Config::get('aliyunsms.accessId');
        $this->accessKey = Config::get('aliyunsms.accessKey');
        $this->client    = new Client($this->endPoint, $this->accessId,
            $this->accessKey);
        /**
         * Step 2. 获取主题引用
         */
        $topicName = Config::get('aliyunsms.topic');
        $topic     = $this->client->getTopicRef($topicName);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($data['sign'], $data['template']);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        $batchSmsAttributes->addReceiver($data['mobile'], $data['vars']);
        $messageAttributes = new MessageAttributes([$batchSmsAttributes]);
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
        $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try {
            $res = $topic->publishMessage($request);

            return [
                'errcode'   => 0,
                'messageId' => $res->getMessageId(),
                'res'       => $res,
            ];
        } catch (MnsException $e) {
            return [
                'errcode' => $e->getMnsErrorCode(),
                'message' => $e->getMessage(),
            ];
        }
    }
}