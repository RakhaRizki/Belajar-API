<?php

namespace App\Http\Middleware;

use App\Models\Comments;
use App\Models\post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

         $id_komentator = Comments::FindOrFail($request->id);
         $user = Auth::user();

        if($id_komentator->user_id != $user->id ){
            return response()->json('Kamu Bukan Pemilik Komen');
        }

        return $next($request);
    }
}
