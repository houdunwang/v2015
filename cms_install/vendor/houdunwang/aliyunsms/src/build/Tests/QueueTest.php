<?php
require_once(dirname(dirname(__FILE__)).'/mns-autoloader.php');

use AliyunMNS\Client;
use AliyunMNS\Constants;
use AliyunMNS\AsyncCallback;
use AliyunMNS\Model\QueueAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Exception\BatchSendFailException;
use AliyunMNS\Exception\BatchDeleteFailException;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Requests\GetQueueAttributeRequest;
use AliyunMNS\Requests\SetQueueAttributeRequest;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Requests\BatchSendMessageRequest;
use AliyunMNS\Requests\BatchReceiveMessageRequest;
use AliyunMNS\Requests\BatchPeekMessageRequest;
use AliyunMNS\Model\SendMessageRequestItem;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    private $accessId;
    private $accessKey;
    private $endPoint;
    private $client;

    private $queueToDelete;

    public function setUp()
    {
        $ini_array = parse_ini_file(__DIR__ . "/aliyun-mns.ini");

        $this->endPoint = $ini_array["endpoint"];
        $this->accessId = $ini_array["accessid"];
        $this->accessKey = $ini_array["accesskey"];

        $this->queueToDelete = array();

        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);
    }

    public function tearDown()
    {
        foreach ($this->queueToDelete as $queueName)
        {
            try {
                $this->client->deleteQueue($queueName);
            } catch (\Exception $e) {
            }
        }
    }

    private function prepareQueue($queueName, $attributes = NULL, $base64=TRUE)
    {
        $request = new CreateQueueRequest($queueName, $attributes);
        $this->queueToDelete[] = $queueName;
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        return $this->client->getQueueRef($queueName, $base64);
    }

    public function testLoggingEnabled()
    {
        $queueName = "testLoggingEnabled";
        $queue = $this->prepareQueue($queueName);

        try
        {
            $attributes = new QueueAttributes;
            $attributes->setLoggingEnabled(false);
            $queue->setAttribute($attributes);
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(false, $res->getQueueAttributes()->getLoggingEnabled());

            $attributes = new QueueAttributes;
            $attributes->setLoggingEnabled(true);
            $queue->setAttribute($attributes);
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(true, $res->getQueueAttributes()->getLoggingEnabled());

            $attributes = new QueueAttributes;
            $queue->setAttribute($attributes);
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(true, $res->getQueueAttributes()->getLoggingEnabled());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testQueueAttributes()
    {
        $queueName = "testQueueAttributes";
        $queue = $this->prepareQueue($queueName);

        try
        {
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($queueName, $res->getQueueAttributes()->getQueueName());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $delaySeconds = 3;
        $attributes = new QueueAttributes;
        $attributes->setDelaySeconds($delaySeconds);
        try
        {
            $res = $queue->setAttribute($attributes);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        try
        {
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($res->getQueueAttributes()->getDelaySeconds(), $delaySeconds);
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testMessageDelaySeconds()
    {
        $queueName = "testMessageDelaySeconds" . uniqid();
        $queue = $this->prepareQueue($queueName, NULL, FALSE);

        $messageBody = "test";
        $bodyMD5 = md5($messageBody);
        $delaySeconds = 1;
        $request = new SendMessageRequest($messageBody, $delaySeconds);
        $receiptHandle = NULL;
        try
        {
            $res = $queue->sendMessage($request);
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testMessageNoBase64()
    {
        $queueName = "testQueueAttributes" . uniqid();
        $queue = $this->prepareQueue($queueName, NULL, FALSE);

        $messageBody = "test";
        $bodyMD5 = md5($messageBody);
        $request = new SendMessageRequest($messageBody);
        try
        {
            $res = $queue->sendMessage($request);
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        try
        {
            $res = $queue->peekMessage();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $receiptHandle = NULL;
        try
        {
            $res = $queue->receiveMessage();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());

            $receiptHandle = $res->getReceiptHandle();
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $newReceiptHandle = NULL;
        try
        {
            $res = $queue->changeMessageVisibility($receiptHandle, 18);
            $this->assertTrue($res->isSucceed());
            $newReceiptHandle = $res->getReceiptHandle();
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        try
        {
            $res = $queue->deleteMessage($receiptHandle);
            $this->assertTrue(FALSE, "Should NOT reach here!");
        }
        catch (MnsException $e)
        {
            $this->assertEquals(Constants::MESSAGE_NOT_EXIST, $e->getMnsErrorCode());
        }

        try
        {
            $res = $queue->deleteMessage($newReceiptHandle);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testMessage()
    {
        $queueName = "testQueueAttributes" . uniqid();
        $queue = $this->prepareQueue($queueName);

        $messageBody = "test";
        $bodyMD5 = md5(base64_encode($messageBody));
        $request = new SendMessageRequest($messageBody);
        try
        {
            $res = $queue->sendMessage($request);
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        try
        {
            $res = $queue->peekMessage();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $receiptHandle = NULL;
        try
        {
            $res = $queue->receiveMessage();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals(strtoupper($bodyMD5), $res->getMessageBodyMD5());

            $receiptHandle = $res->getReceiptHandle();
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $newReceiptHandle = NULL;
        try
        {
            $res = $queue->changeMessageVisibility($receiptHandle, 18);
            $this->assertTrue($res->isSucceed());
            $newReceiptHandle = $res->getReceiptHandle();
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        try
        {
            $res = $queue->deleteMessage($receiptHandle);
            $this->assertTrue(FALSE, "Should NOT reach here!");
        }
        catch (MnsException $e)
        {
            $this->assertEquals(Constants::MESSAGE_NOT_EXIST, $e->getMnsErrorCode());
        }

        try
        {
            $res = $queue->deleteMessage($newReceiptHandle);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testBatchNoBase64()
    {
        $queueName = "testBatch" . uniqid();
        $queue = $this->prepareQueue($queueName, NULL, FALSE);

        $messageBody = "test";
        $bodyMD5 = md5($messageBody);

        $numOfMessages = 3;

        $item = new SendMessageRequestItem($messageBody);
        $items = array($item, $item, $item);
        $request = new BatchSendMessageRequest($items);
        try
        {
            $res = $queue->batchSendMessage($request);
            $this->assertTrue($res->isSucceed());

            $responseItems = $res->getSendMessageResponseItems();
            $this->assertTrue(count($responseItems) == 3);
            foreach ($responseItems as $item)
            {
                $this->assertEquals(strtoupper($bodyMD5), $item->getMessageBodyMD5());
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
            if ($e instanceof BatchSendFailException)
            {
                var_dump($e->getSendMessageResponseItems());
            }
        }

        try
        {
            $res = $queue->batchPeekMessage($numOfMessages);
            $this->assertTrue($res->isSucceed());

            $messages = $res->getMessages();
            $this->assertEquals($numOfMessages, count($messages));
            foreach ($messages as $message)
            {
                $this->assertEquals(strtoupper($bodyMD5), $message->getMessageBodyMD5());
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $receiptHandles = array();
        $request = new BatchReceiveMessageRequest($numOfMessages);
        try
        {
            $res = $queue->batchReceiveMessage($request);
            $this->assertTrue($res->isSucceed());

            $messages = $res->getMessages();
            $this->assertEquals($numOfMessages, count($messages));
            foreach ($messages as $message)
            {
                $this->assertEquals(strtoupper($bodyMD5), $message->getMessageBodyMD5());
                $receiptHandles[] = $message->getReceiptHandle();
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $errorReceiptHandle = "1-ODU4OTkzNDU5My0xNDM1MTk3NjAwLTItNg==";
        $receiptHandles[] = $errorReceiptHandle;
        try
        {
            $res = $queue->batchDeleteMessage($receiptHandles);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue($e instanceof BatchDeleteFailException);
            $items = $e->getDeleteMessageErrorItems();
            $this->assertEquals(1, count($items));
            $this->assertEquals($errorReceiptHandle, $items[0]->getReceiptHandle());
        }
    }

    public function testBatch()
    {
        $queueName = "testBatch" . uniqid();
        $queue = $this->prepareQueue($queueName);

        $messageBody = "test";
        $bodyMD5 = md5(base64_encode($messageBody));

        $numOfMessages = 3;

        $item = new SendMessageRequestItem($messageBody);
        $items = array($item, $item, $item);
        $request = new BatchSendMessageRequest($items);
        try
        {
            $res = $queue->batchSendMessage($request);
            $this->assertTrue($res->isSucceed());

            $responseItems = $res->getSendMessageResponseItems();
            foreach ($responseItems as $item)
            {
                $this->assertEquals(strtoupper($bodyMD5), $item->getMessageBodyMD5());
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
            if ($e instanceof BatchSendFailException)
            {
                var_dump($e->getSendMessageResponseItems());
            }
        }

        try
        {
            $res = $queue->batchPeekMessage($numOfMessages);
            $this->assertTrue($res->isSucceed());

            $messages = $res->getMessages();
            $this->assertEquals($numOfMessages, count($messages));
            foreach ($messages as $message)
            {
                $this->assertEquals(strtoupper($bodyMD5), $message->getMessageBodyMD5());
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $receiptHandles = array();
        $request = new BatchReceiveMessageRequest($numOfMessages);
        try
        {
            $res = $queue->batchReceiveMessage($request);
            $this->assertTrue($res->isSucceed());

            $messages = $res->getMessages();
            $this->assertEquals($numOfMessages, count($messages));
            foreach ($messages as $message)
            {
                $this->assertEquals(strtoupper($bodyMD5), $message->getMessageBodyMD5());
                $receiptHandles[] = $message->getReceiptHandle();
            }
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $errorReceiptHandle = "1-ODU4OTkzNDU5My0xNDM1MTk3NjAwLTItNg==";
        $receiptHandles[] = $errorReceiptHandle;
        try
        {
            $res = $queue->batchDeleteMessage($receiptHandles);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue($e instanceof BatchDeleteFailException);
            $items = $e->getDeleteMessageErrorItems();
            $this->assertEquals(1, count($items));
            $this->assertEquals($errorReceiptHandle, $items[0]->getReceiptHandle());
        }
    }
}

?>
