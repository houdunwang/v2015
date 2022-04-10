<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
include_once 'Autoloader/Autoloader.php';
include_once 'Regions/EndpointConfig.php';
include_once 'Regions/LocationService.php';

//config sdk auto load path.
Autoloader::addAutoloadPath("aliyun-php-sdk-ecs");
Autoloader::addAutoloadPath("aliyun-php-sdk-batchcompute");
Autoloader::addAutoloadPath("aliyun-php-sdk-sts");
Autoloader::addAutoloadPath("aliyun-php-sdk-push");
Autoloader::addAutoloadPath("aliyun-php-sdk-ram");
Autoloader::addAutoloadPath("aliyun-php-sdk-ubsms");
Autoloader::addAutoloadPath("aliyun-php-sdk-ubsms-inner");
Autoloader::addAutoloadPath("aliyun-php-sdk-green");
Autoloader::addAutoloadPath("aliyun-php-sdk-dm");
Autoloader::addAutoloadPath("aliyun-php-sdk-iot");
Autoloader::addAutoloadPath("aliyun-php-sdk-jaq");
Autoloader::addAutoloadPath("aliyun-php-sdk-cs");
Autoloader::addAutoloadPath("aliyun-php-sdk-live");
Autoloader::addAutoloadPath("aliyun-php-sdk-vpc");
Autoloader::addAutoloadPath("aliyun-php-sdk-kms");
Autoloader::addAutoloadPath("aliyun-php-sdk-rds");
Autoloader::addAutoloadPath("aliyun-php-sdk-slb");
Autoloader::addAutoloadPath("aliyun-php-sdk-cms");

//config http proxy
define('ENABLE_HTTP_PROXY', false);
define('HTTP_PROXY_IP', '127.0.0.1');
define('HTTP_PROXY_PORT', '8888');
