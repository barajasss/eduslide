<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Favorite;
use App\Models\Slide;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('favorites') && $request->boolean('favorites')) {
            $favoriteIds = Favorite::where('user_id', auth()->user()->id)->pluck('lesson_id')->toArray();
            $lessons = Lesson::with('user')->whereIn('id', $favoriteIds)->latest()->get()->toArray();
        } else if ($request->has('my_lessons') && $request->boolean('my_lessons')) {
            $lessons = Lesson::with('user')->where('user_id', auth()->user()->id)->latest()->get()->toArray();
        } else {
            $lessons = Lesson::with('user')->latest()->get()->toArray();
        }

        // paginate data

        if ($request->has('page')) {
            $page = $request->input('page');
            $limit = $request->input('limit', 10);
            $paginatedLessons = array_slice($lessons, ($page - 1) * $limit, $limit);
        }

        if (!is_null($lessons)) {
            return ['lessons' => $paginatedLessons, 'totalResults' => count($lessons)];
        }
        return ['success' => false];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $lesson = Lesson::create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title', ''),
            'description' => $request->input('description', '')
        ]);
        if ($lesson) {
            return $lesson;
        }
        return ['success' => false];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $lesson = Lesson::with('user')->find($id);
        if (!is_null($lesson)) {
            return $lesson;
        }
        return ['success' => false];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if (!empty($lesson) && !$lesson->belongsToUser(auth()->user()->id)) {
            return ['message' => 'The lesson does not belong to the user', 'success' => false];
        }
        $title = $request->input('title');
        $description  = $request->input('description');

        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($description)) {
            $data['description'] = $description;
        }

        $result = Lesson::where('id', $id)->update($data);
        if ($result) {
            $updatedLesson = Lesson::find($id);
            return $updatedLesson;
        }
        return ['success' => false];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        if (!empty($lesson) && !$lesson->belongsToUser(auth()->user()->id)) {
            return ['message' => 'The lesson does not belong to the user', 'success' => false];
        }
        $result = Lesson::where('id', $id)->delete();
        // delete also its slides;
        Slide::where('lesson_id', $id)->delete();
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
