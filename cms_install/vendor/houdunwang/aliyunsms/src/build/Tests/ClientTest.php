<?php
require_once(dirname(dirname(__FILE__)).'/mns-autoloader.php');

use AliyunMNS\Client;
use AliyunMNS\Constants;
use AliyunMNS\AsyncCallback;
use AliyunMNS\Model\QueueAttributes;
use AliyunMNS\Model\TopicAttributes;
use AliyunMNS\Model\AccountAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Requests\CreateTopicRequest;
use AliyunMNS\Requests\ListQueueRequest;
use AliyunMNS\Requests\ListTopicRequest;
use AliyunMNS\Requests\SetAccountAttributesRequest;
use AliyunMNS\Requests\GetAccountAttributesRequest;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $accessId;
    private $accessKey;
    private $endPoint;
    private $client;

    private $queueToDelete;
    private $topicToDelete;

    public function setUp()
    {
        $ini_array = parse_ini_file(__DIR__ . "/aliyun-mns.ini");

        $this->endPoint = $ini_array["endpoint"];
        $this->accessId = $ini_array["accessid"];
        $this->accessKey = $ini_array["accesskey"];

        $this->queueToDelete = array();
        $this->topicToDelete = array();

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
        foreach ($this->topicToDelete as $topicName)
        {
            try {
                $this->client->deleteTopic($topicName);
            } catch (\Exception $e) {
            }
        }
    }

    public function testAccountAttributes()
    {
        try
        {
            $attributes = new AccountAttributes;
            $attributes->setLoggingBucket("Test");
            $this->client->setAccountAttributes($attributes);
            $res = $this->client->getAccountAttributes();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals("Test", $res->getAccountAttributes()->getLoggingBucket());

            $attributes = new AccountAttributes;
            $this->client->setAccountAttributes($attributes);
            $res = $this->client->getAccountAttributes();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals("Test", $res->getAccountAttributes()->getLoggingBucket());

            $attributes = new AccountAttributes;
            $attributes->setLoggingBucket("");
            $this->client->setAccountAttributes($attributes);
            $res = $this->client->getAccountAttributes();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals("", $res->getAccountAttributes()->getLoggingBucket());
        }
        catch (MnsException $e)
        {
            $this->assertEquals($e->getMnsErrorCode(), Constants::INVALID_ARGUMENT);
        }
    }

    public function testCreateQueueAsync()
    {
        $queueName = "testCreateQueueAsync";
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;

        // Async Call with callback
        try
        {
            $res = $this->client->createQueueAsync($request,
                new AsyncCallback(
                    function($response) {
                        $this->assertTrue($response->isSucceed());
                    },
                    function($e) {
                        $this->assertTrue(FALSE, $e);
                    }
                )
            );
            $res = $res->wait();

            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // Async call without callback
        try
        {
            $res = $this->client->createQueueAsync($request);
            $res = $res->wait();

            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testCreateQueueSync()
    {
        $queueName = "testCreateQueueSync";

        // 1. create queue with InvalidArgument
        $attributes = new QueueAttributes;
        $attributes->setPollingWaitSeconds(60);

        $request = new CreateQueueRequest($queueName, $attributes);
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue(FALSE, "Should throw InvalidArgumentException");
        }
        catch (MnsException $e)
        {
            $this->assertEquals($e->getMnsErrorCode(), Constants::INVALID_ARGUMENT);
        }

        // 2. create queue
        $request = new CreateQueueRequest($queueName);
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

        // 3. create queue with same attributes
        $request = new CreateQueueRequest($queueName);
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

        // 4. create same queue with different attributes
        $attributes = new QueueAttributes;
        $attributes->setPollingWaitSeconds(20);

        $request = new CreateQueueRequest($queueName, $attributes);
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue(FALSE, "Should throw QueueAlreadyExistException");
        }
        catch (MnsException $e)
        {
            $this->assertEquals($e->getMnsErrorCode(), Constants::QUEUE_ALREADY_EXIST);
        }
    }

    public function testListQueue()
    {
        $queueNamePrefix = uniqid();
        $queueName1 = $queueNamePrefix . "testListQueue1";
        $queueName2 = $queueNamePrefix . "testListQueue2";

        // 1. create queue
        $request = new CreateQueueRequest($queueName1);
        $this->queueToDelete[] = $queueName1;
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $request = new CreateQueueRequest($queueName2);
        $this->queueToDelete[] = $queueName2;
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // 2. list queue
        $queueName1Found = FALSE;
        $queueName2Found = FALSE;

        $count = 0;
        $request = new ListQueueRequest(1, $queueNamePrefix);

        while ($count < 2) {
            try
            {
                $res = $this->client->listQueue($request);
                $this->assertTrue($res->isSucceed());

                $queueNames = $res->getQueueNames();
                foreach ($queueNames as $queueName) {
                    if ($queueName == $queueName1) {
                        $queueName1Found = TRUE;
                    } elseif ($queueName == $queueName2) {
                        $queueName2Found = TRUE;
                    } else {
                        $this->assertTrue(FALSE, $queueName . " Should not be here.");
                    }
                }

                if ($count > 0) {
                    $this->assertTrue($res->isFinished(), implode(", ", $queueNames));
                }
                $request->setMarker($res->getNextMarker());
            }
            catch (MnsException $e)
            {
                $this->assertTrue(FALSE, $e);
            }
            $count += 1;
        }

        $this->assertTrue($queueName1Found, $queueName1 . " Not Found!");
        $this->assertTrue($queueName2Found, $queueName2 . " Not Found!");
    }

    public function testListQueueAsync()
    {
        $queueNamePrefix = uniqid();
        $queueName1 = $queueNamePrefix . "testListQueue1";
        $queueName2 = $queueNamePrefix . "testListQueue2";

        // 1. create queue
        $request = new CreateQueueRequest($queueName1);
        $this->queueToDelete[] = $queueName1;
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $request = new CreateQueueRequest($queueName2);
        $this->queueToDelete[] = $queueName2;
        try
        {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // 2. list queue
        $queueName1Found = FALSE;
        $queueName2Found = FALSE;

        $count = 0;
        $request = new ListQueueRequest(1, $queueNamePrefix);

        while ($count < 2) {
            try
            {
                $res = $this->client->listQueueAsync($request,
                    new AsyncCallback(
                        function($response) use ($count, &$request, $queueName1, $queueName2, &$queueName1Found, &$queueName2Found) {
                            $this->assertTrue($response->isSucceed());

                            $queueNames = $response->getQueueNames();
                            foreach ($queueNames as $queueName) {
                                if ($queueName == $queueName1) {
                                    $queueName1Found = TRUE;
                                } elseif ($queueName == $queueName2) {
                                    $queueName2Found = TRUE;
                                } else {
                                    $this->assertTrue(FALSE, $queueName . " Should not be here.");
                                }
                            }

                            if ($count > 0) {
                                $this->assertTrue($response->isFinished(), implode(", ", $queueNames));
                            }
                            $request->setMarker($response->getNextMarker());
                        },
                        function($e) {
                            $this->assertTrue(FALSE, $e);
                        }
                    )
                );
                $res = $res->wait();

                $this->assertTrue($res->isSucceed());
            }
            catch (MnsException $e)
            {
                $this->assertTrue(FALSE, $e);
            }
            $count += 1;
        }

        $this->assertTrue($queueName1Found, $queueName1 . " Not Found!");
        $this->assertTrue($queueName2Found, $queueName2 . " Not Found!");
    }

    public function testDeleteQueue()
    {
        $queueName = "testDeleteQueue";

        // 1. create queue
        $request = new CreateQueueRequest($queueName);
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

        // 2. delete queue
        try
        {
            $res = $this->client->deleteQueue($queueName);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testDeleteQueueAsync()
    {
        $queueName = "testDeleteQueueAsync";

        // 1. create queue
        $request = new CreateQueueRequest($queueName);
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

        // 2. delete Queue
        try
        {
            $res = $this->client->deleteQueueAsync($queueName);
            $res = $res->wait();

            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testCreateTopicSync()
    {
        $topicName = "testCreateTopicSync";

        // 1. create topic with InvalidArgument
        $attributes = new TopicAttributes;
        $attributes->setMaximumMessageSize(65 * 1024);

        $request = new CreateTopicRequest($topicName, $attributes);
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue(FALSE, "Should throw InvalidArgumentException");
        }
        catch (MnsException $e)
        {
            $this->assertEquals($e->getMnsErrorCode(), Constants::INVALID_ARGUMENT);
        }

        // 2. create topic
        $request = new CreateTopicRequest($topicName);
        $this->topicToDelete[] = $topicName;
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // 3. create topic with same attributes
        $request = new CreateTopicRequest($topicName);
        $this->topicToDelete[] = $topicName;
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // 4. create same topic with different attributes
        $attributes = new TopicAttributes;
        $attributes->setMaximumMessageSize(10 * 1024);

        $request = new CreateTopicRequest($topicName, $attributes);
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue(FALSE, "Should throw TopicAlreadyExistException");
        }
        catch (MnsException $e)
        {
            $this->assertEquals($e->getMnsErrorCode(), Constants::TOPIC_ALREADY_EXIST);
        }
    }

    public function testListTopic()
    {
        $topicNamePrefix = uniqid();
        $topicName1 = $topicNamePrefix . "testListTopic1";
        $topicName2 = $topicNamePrefix . "testListTopic2";

        // 1. create Topic
        $request = new CreateTopicRequest($topicName1);
        $this->topicToDelete[] = $topicName1;
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        $request = new CreateTopicRequest($topicName2);
        $this->topicToDelete[] = $topicName2;
        try
        {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        }
        catch (MnsException $e)
        {
            $this->assertTrue(FALSE, $e);
        }

        // 2. list Topic
        $topicName1Found = FALSE;
        $topicName2Found = FALSE;

        $count = 0;
        $request = new ListTopicRequest(1, $topicNamePrefix);

        while ($count < 2) {
            try
            {
                $res = $this->client->listTopic($request);
                $this->assertTrue($res->isSucceed());

                $topicNames = $res->getTopicNames();
                foreach ($topicNames as $topicName) {
                    if ($topicName == $topicName1) {
                        $topicName1Found = TRUE;
                    } elseif ($topicName == $topicName2) {
                        $topicName2Found = TRUE;
                    } else {
                        $this->assertTrue(FALSE, $topicName . " Should not be here.");
                    }
                }

                if ($count > 0) {
                    $this->assertTrue($res->isFinished(), implode(", ", $topicNames));
                }
                $request->setMarker($res->getNextMarker());
            }
            catch (MnsException $e)
            {
                $this->assertTrue(FALSE, $e);
            }
            $count += 1;
        }

        $this->assertTrue($topicName1Found, $topicName1 . " Not Found!");
        $this->assertTrue($topicName2Found, $topicName2 . " Not Found!");
    }
}

?>
