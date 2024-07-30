<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{

    public static function middleware(): array{
        return [
            new Middleware('permission:view articles', only: ['index']),
            new Middleware('permission:edit articles', only: ['edit']),
            new Middleware('permission:create articles', only: ['create']),
            new Middleware('permission:delete articles', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('articles.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3',
            'author' => 'required|min:3',
        ]);
        if($validator->passes()){
            $article = new Article();
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            toastr()
            ->closeButton(true)
            ->success('Article added successfully.');
            return redirect()->route('articles.index');

        }else{
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articles = Article::findOrFail($id);
        return view('articles.edit',compact('articles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $articles = Article::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|unique:articles,title,'.$id.'id',
            'author' => 'required|min:3,author,'.$id.'id',
        ]);
        if($validator->passes()){
            
            $articles->title = $request->title;
            $articles->author = $request->author;
            $articles->save();
            toastr()
            ->closeButton(true)
            ->success('Updated Successfully');
            return redirect()->route('articles.index');
        }else{
            return redirect()->route('articles.edit',$id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $articles = Article::findOrFail($id);
        $articles->delete();
    
        toastr()
            ->closeButton(true)
            ->success('Article deleted successfully');
        return redirect();
    }
}
