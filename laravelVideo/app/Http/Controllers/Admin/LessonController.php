<?php

namespace App\Http\Controllers\Admin;

use App\Model\Lesson;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lesson::get();

        return view('admin.lesson.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        $lesson['title']     = $request['title'];
        $lesson['introduce'] = $request['introduce'];
        $lesson['preview']   = $request['preview'];
        $lesson['iscommend'] = $request['iscommend'];
        $lesson['ishot']     = $request['ishot'];
        $lesson['click']     = $request['click'];
        $lesson->save();

        $videos = json_decode($request['videos'], true);
        foreach ($videos as $video) {
            $lesson->videos()->create([
                'title' => $video['title'],
                'path'  => $video['path'],
            ]);
        }

        return redirect('/admin/lesson');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::find($id);
        $videos = json_encode($lesson->videos()->get()->toArray(), JSON_UNESCAPED_UNICODE);

        return view('admin.lesson.edit', compact('lesson', 'videos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lesson              = Lesson::find($id);
        $lesson['title']     = $request['title'];
        $lesson['introduce'] = $request['introduce'];
        $lesson['preview']   = $request['preview'];
        $lesson['iscommend'] = $request['iscommend'];
        $lesson['ishot']     = $request['ishot'];
        $lesson['click']     = $request['click'];
        $lesson->save();
        Video::where('lesson_id', $id)->delete();
        $videos = json_decode($request['videos'], true);
        foreach ($videos as $video) {
            $lesson->videos()->create([
                'title' => $video['title'],
                'path'  => $video['path'],
            ]);
        }

        return redirect('/admin/lesson');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lesson::destroy($id);
        Video::where('lesson_id', $id)->delete();

        return $this->success('删除成功');
    }
}
