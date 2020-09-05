<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SubJefe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $user = Auth::user();
        if($user->esJefe() || $user->esSub()){
            return $next($request);
        }
        return redirect('/');       
    }
}
