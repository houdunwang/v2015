<?php

namespace tests;

use houdunwang\db\Db;

class QueryTest extends Migrate
{
    /**
     * @test
     */
    public function get()
    {
        $d = Db::table('news')->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->get(['title', 'click']);
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('title', 'hdphp')->first();
        $this->assertInternalType('array', $d);

        $title = Db::table('news')->where('title', 'hdphp')->pluck('title');
        $this->assertEquals('hdphp', $title);

        $d = Db::table('news')->lists('title');
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->lists('id,title');
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->lists('id,title,click');
        $this->assertEquals(1, $d[1]['id']);

        $d = Db::table('news')->where('title', 'like', "%hdphp%")->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->field('title AS name,click')->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->field(['id', 'title'])->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->getByTitle("hdphp");
        $this->assertInternalType('array', $d);

        $db = Db::table('news')->field('title AS name', 'click', 'id');
        $d  = $db->where('id', '>', 2)->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('id', '>', 1)->where('id', '<', 10)->get(
        );
        $this->assertInternalType('array', $d);

        $where = [
            ['id', '>', 1],
            ['click', '>', 1],
        ];
        $d     = Db::table('news')->where($where)->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('id', '>', 1)->andwhere('id', '<', 10)
            ->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('id', '>', 1)->orwhere('id', '<', 10)
            ->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('id', '>', 1)->logic('and')->where(
            'id',
            '<',
            22
        )->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereRaw(
            'id > ? and title =?',
            [1, 'admin']
        )->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereBetween('id', [10, 30])->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereNotBetween('id', [10, 30])->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereIn('id', [2, 3, 9])->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereNotIn('id', [1, 2])->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereNull('click')->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->whereNotNull('id')->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->where('id', '>', 1)->logic('AND')->whereBetween(
            'id',
            [2, 3]
        )->get();
        $this->assertCount(2, $d);

        $d = Db::table('news')->orderBy('id', 'DESC')->orderBy('click', 'ASC')
            ->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->groupBy('click')->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->groupBy('click')->having('count(click)', '>', 2)
            ->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->limit(2, 5)->get();
        $this->assertInternalType('array', $d);

        $d = Db::table("news")->count('id');
        $this->assertInternalType('int', $d);

        $d = Db::table("news")->max('id');
        $this->assertInternalType('int', $d);

        $d = Db::table("news")->min('id');
        $this->assertInternalType('int', $d);

        $d = Db::table("news")->avg('id');
        $this->assertInternalType('int', $d);

        $d = Db::table("news")->sum('id');
        $this->assertInternalType('int', $d);
    }

    /**
     * @test
     */
    public function join()
    {
        $d = Db::table('news')
            ->join('category', 'news.category_id', '=', 'category.id')
            ->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->leftJoin(
            'category',
            'news.category_id',
            '=',
            'category.id'
        )->get();
        $this->assertInternalType('array', $d);

        $d = Db::table('news')->rightJoin(
            'category',
            'news.category_id',
            '=',
            'category.id'
        )->get();
        $this->assertInternalType('array', $d);
    }

    /**
     * @test
     */
    public function getQueryLog()
    {
        $d = Db::getQueryLog();
        $this->assertInternalType('array', $d);
    }

    /**
     * @test
     */
    public function paginate()
    {
        $users = Db::table('news')->paginate(1);
        $this->assertInternalType('string', $users->links());
    }

    /**
     * @test
     */
    public function transaction()
    {
        Db::transaction(
            function () {
                $status = true;
                if ( ! Db::execute('DELETE FROM news WHERE id=?', [1])) {
                    $status = false;
                }
                if ( ! Db::execute('DELETE FROM news WHERE id=?', [3])) {
                    $status = false;
                }
                $this->assertTrue($status);
            }
        );
    }
}