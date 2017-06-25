<?php

namespace tests;

use houdunwang\db\Db;

class DbTest extends Migrate
{
    /**
     * @test
     */
    public function query()
    {
        $d = Db::query("select * from news");
        $this->assertInternalType('array', $d);

        $d = Db::query(
            "select * from news where id=:id AND title=:title",
            [':id' => 1, ':title' => 'hdphp']
        );
        $this->assertNotEmpty($d);
        $d = Db::query(
            "select * from news where title like ?",
            ['%hdphp%']
        );
        $this->assertNotEmpty($d);
    }

    /**
     * @test
     */
    public function insert()
    {
        $d = Db::table('news')->insert(
            ['title' => '向军']
        );
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function firstOrCreate()
    {
        $status = Db::table('news')->firstOrCreate(
            ['title' => '李四'],
            ['title' => '小米']
        );
        $this->assertTrue($status);
    }

    /**
     * @test
     */
    public function replace()
    {
        $d = Db::table('news')->replace(
            ['id' => 2, 'title' => 'hdcms']
        );
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function insertGetId()
    {
        $d = Db::table('news')->insertGetId(
            ['title' => '向军']
        );
        $this->assertInternalType('int', $d);
    }

    /**
     * @test
     */
    public function update()
    {
        $d = Db::table('news')->where("id", 2)->update(
            ['title' => '后盾网']
        );
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function delete()
    {
        $d = Db::table('news')->where('id', 3)->delete();
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function increment()
    {
        $d = Db::table("news")->where('id', 1)->increment(
            'click',
            20
        );
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function decrement()
    {
        $d = Db::table("news")->where('id', 1)->decrement(
            'click',
            2
        );
        $this->assertTrue($d);
    }

    /**
     * @test
     */
    public function getInsertId()
    {
        $db = Db::table('news');
        $db->insert(['title' => '后盾网']);
        $d = $db->getInsertId();
        $this->assertInternalType('int', $d);
    }

    /**
     * @test
     */
    public function getAffectedRow()
    {
        $db = Db::table('news');
        $db->update(['title' => '后盾人']);
        $d = $db->getAffectedRow();
        $this->assertInternalType('int', $d);
    }
}