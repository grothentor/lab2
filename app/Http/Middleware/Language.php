<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 07.03.2017
 * Time: 20:27
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
{
    public function handle(Request $request, Closure $next)
    {
        if (!($lang = session('language'))) {
            $user = auth()->user() ?? auth()->guard('api')->user();
            if ($user) {
                $lang = $user->lang;
                session(['language' => $lang]);
            } else {
                $languages = $request->getLanguages();
                $languages = array_uintersect($languages, config('app.available_locales'), "strcasecmp");
                $lang = array_first($languages, null, config('app.locale'));
            }
        }

        \App::setLocale($lang);
        return $next($request);
    }
}
