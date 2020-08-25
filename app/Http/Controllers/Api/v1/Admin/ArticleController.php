<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
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
        $articles = Article::orderByDesc('created_at')->paginate(8);
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
            'published' => $request->published === "false" ? 0 : 1,
            'user_id' => $request->user_id,
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
        $article = Article::find($id)->with('user')->first();
        $latestArticles = Article::orderByDesc('created_at')->limit(4)->get();
        return response()->json(compact(['article','latestArticles']),200);
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

        $article = Article::find($id);

        if($request->hasFile('image')){
            $oldImagePath = 'images/articles/' . $article->image;
            File::delete(public_path($oldImagePath));
            $imageName = Str::random(10) . '.' . $request->image->extension();
            $request->image->move(public_path('/images/articles'), $imageName);
            $article->image = $imageName;
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->published = $request->published === "false" ? 0 : 1;
        $article->user_id = $request->user_id;
        $article->save();

        return response()->json(['message' => 'Article has been successfuly updated!'],200);

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

        File::delete(public_path($oldImagePath));

        $article->delete();
        return response()->json(['message' => 'Article has been deleted successfully!'],200);
    }
}
