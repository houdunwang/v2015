<?php

namespace tests;

use houdunwang\dir\Dir;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testTree()
    {
        $this->assertInternalType('array', Dir::tree('.'));
    }

    public function testSize()
    {
        $this->assertInternalType('int', Dir::size('.'));
    }

    public function testCreate()
    {
        $this->assertTrue(Dir::create('tests/temp'));
    }

    public function testDel()
    {
        $this->assertTrue(Dir::del('tests/temp'));
    }

    public function testCopy()
    {
        $this->assertTrue(Dir::copy('src', 'tests/src'));
    }

    public function testCopyFile()
    {
        $this->assertTrue(Dir::copyFile('README.md', 'tests/README.md'));
    }

    public function testMoveFile()
    {
        $this->assertTrue(Dir::moveFile('tests/README.md', 'tests/src'));
    }

    public function testMove()
    {
        $this->assertTrue(Dir::move('tests/src', 'tests/a'));
    }

    public function testDelTemp()
    {
        $this->assertTrue(Dir::del('tests/a'));
    }
}