<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

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
    public function index()
    {
        $lessons = Lesson::with('user')->get();
        if (!is_null($lessons)) {
            return $lessons;
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

        $lesson = Lesson::find($id);
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
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
