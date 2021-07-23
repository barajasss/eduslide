<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->user()->id)->get();
        return $favorites;
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
            'lesson_id' => 'required|integer'
        ]);

        $lessonId = $request->input('lesson_id');

        // check if already exists
        $favoriteFound = Favorite::where([
            'user_id' => auth()->user()->id,
            'lesson_id' => $lessonId
        ])->first();

        if (!empty($favoriteFound)) {
            return response([
                'message' => 'Already selected as favorite'
            ], 400);
        }


        $favorite = Favorite::create([
            'user_id' => auth()->user()->id,
            'lesson_id' => $lessonId
        ]);
        if (!empty($favorite)) {
            return $favorite;
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
        $favorite = Favorite::find($id);

        if (!empty($favorite->user) && $favorite->user->id === auth()->user()->id) {
            $deleted = $favorite->delete();
        } else {
            return ['success' => false, 'message' => 'The document to delete does not belong to the user'];
        }

        if (!empty($deleted)) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
