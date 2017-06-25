<?php

namespace tests;

use houdunwang\config\Config;
use PHPUnit\Framework\TestCase;

abstract class Base extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::env(dirname(__DIR__));
        Config::loadFiles(__DIR__.'/../config');
    }
}