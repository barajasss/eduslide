<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
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
        if ($request->has('lesson_id')) {
            $slides = Slide::where('lesson_id', $request->input('lesson_id'))->get();
        } else {
            $slides = Slide::get();
        }
        return $slides;
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
            'lesson_id' => 'required|integer',
            'title' => 'required',
            'content' => 'string'
        ]);
        $slide = Slide::create([
            'lesson_id' => $request->input('lesson_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content', ''),
        ]);
        if (!empty($slide)) {
            return $slide;
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
        $slide = Slide::find($id);
        if (!empty($slide)) {
            return $slide;
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
        $slide = Slide::find($id);
        if (!empty($slide) && !$slide->belongsToUser(auth()->user()->id)) {
            return ['message' => 'The slide does not belong to the user', 'success' => false];
        }

        $title = $request->input('title');
        $content = $request->input('content');

        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($content)) {
            $data['content'] = $content;
        }

        $updated = Slide::where('id', $id)->update($data);

        if ($updated) {
            $slide = Slide::find($id);
            return $slide;
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
        $slide = Slide::find($id);
        if (!empty($slide) && !$slide->belongsToUser(auth()->user()->id)) {
            return ['message' => 'The slide does not belong to the user', 'success' => false];
        }

        $deleted = Slide::where('id', $id)->delete();

        if ($deleted) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
