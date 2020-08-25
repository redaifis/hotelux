<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderByDesc('created_at')->limit(8)->get();
        return response()->json(compact('articles'),200);
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
}
