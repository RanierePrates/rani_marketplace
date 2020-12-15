<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
{
    /**
     * Verifica se o usuário já possui uma loja, se possuir redireciona
     * Só é possivel criar uma loja por usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->store()->count()) {
            flash('Você já possui uma loja!')->warning();
            return redirect()->route('admin.stores.index');
        }

        return $next($request);
    }
}
