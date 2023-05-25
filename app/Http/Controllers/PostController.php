<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware(['auth:sanctum'])->only('store', 'update');
        $this->middleware(['pemilik-news'])->only('update');
    }
    
     public function index(){

        $posts = post::all();
        return PostResource::collection($posts);

    }

    public function show($id){

        $post = post::with('writer:id,username')->FindOrFail($id);
        return new PostDetailResource($post);

    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(Request $request){

         $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        if($request->file) {

            $validated = $request->validate([
                'file' => 'mimes:jpeg,jpg,png|max:10000'
            ]);

            $filename = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $filename. '.'. $extension );

            $request['image'] = $filename . '.'. $extension;
            $request['author'] = Auth::user()->id;
            $post = post::create($request->all());

        }

         $request['author'] = Auth::user()->id;
         $post = post::create($request->all());

        $post = post::create([
            'title' => $request->input('title'),
            'news_content' => $request->input('news_content'),
            'author' => Auth::user()->id,   
            'image' => $filename. '.' .$extension,
        ]);

        return new PostDetailResource($post->loadmissing('writer'));

    }

    public function update(Request $request, $id){

        $request -> validate([
            'title' => 'required|string',
            'news_content' => 'required|string',
        ]);

        $post = post::FindOrFail($id);
        $post = update($request->all());

        return new PostDetailResource($post->loadmissing('writer'));

    }

    public function delete($id){

        $post = post::FindOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Berhasil Menghapus Berita'
        ]);
    
    }


}
