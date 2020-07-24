<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderByDesc('created_at')->get();
        return response()->json(compact('articles'),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!$request->hasFile('image')) return response()->json(['message' => 'Please insert a valid image: png or jpg!'], 422);

        $imageName = Str::random(10) . '.' . $request->image->extension();
        $request->image->move(public_path('/images/articles'), $imageName);

        $article = Article::create([
            'title' => Str::title($request->title),
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return response()->json(['message' => 'Articles has been created successfully!', 'article' => $article], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        return response()->json(compact('article'),200);
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

        if(!$request->hasFile('image')) return response()->json(['message' => 'Please insert a valid image: png or jpg!'], 422);

        $article = Article::find($id);

        $oldImagePath = 'images/articles/' . $article->image;

        if(File::delete(public_path($oldImagePath))){
            $imageName = Str::random(10) . '.' . $request->image->extension();
            $request->image->move(public_path('/images/articles'), $imageName);
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->image = $imageName;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        $oldImagePath = 'images/articles/' . $article->image;

        if(File::delete(public_path($oldImagePath))){
            $article->delete();
            return response()->json(['message' => 'Article has been deleted successfully!'],200);
        }

        return response()->json(['message' => 'There was an error deleting the article!'],422);
    }
}
