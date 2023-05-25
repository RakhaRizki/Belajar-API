<?php

namespace App\Http\Middleware;

use App\Models\post;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
   
    public function handle(Request $request, Closure $next,) : Response
    {
        
        $id_author = post::FindOrFail($request->id);
        $user = Auth::user();

        if($id_author->author != $user->id ){
            return response()->json('Kamu Bukan Pemilik Postingan');
        }

        return $next($request);

    }
}
