<?php
Route::group(['namespace' => 'Api'], function () {
    //显示标签
    Route::get('tags', 'ContentController@tags');
    //获取课程
    Route::get('lesson/{tid}', 'ContentController@lesson');
    //推荐课程
    Route::get('commendLesson/{row}', 'ContentController@commendLesson');
    //热门课程
    Route::get('hotLesson/{row}', 'ContentController@hotLesson');
    //视频列表
    Route::get('videos/{lessonId}', 'ContentController@videos');
});