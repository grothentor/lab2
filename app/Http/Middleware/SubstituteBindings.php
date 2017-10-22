<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\App;

class SubstituteBindings
{
    /**
     * The router instance.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new bindings substitutor.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->router->substituteBindings($route = $request->route());
        $this->router->substituteImplicitBindings($route);

        $checkAccess = in_array($route->methods()[0], ['PATCH', 'DELETE', 'POST']) ||
            false !== strpos($route->uri(), 'edit');

        $user = auth()->guard($guard)->user();
        $isApi = $guard !== null;

        if ($user && $checkAccess && 'superadmin' !== $user->role) {
            foreach ($route->parameters as $parameter) {
                if (is_object($parameter) &&
                    is_subclass_of($parameter, \App\CustomModel::class) && (
                        ($parameter->hasAttribute('user_id') && !in_array($parameter->user_id, $user->getAvailableIds())) ||
                        (is_subclass_of($parameter, \App\Ad::class) &&
                            $parameter->realty->user_id !== $user->id)
                    )
                ) {
                    if ($isApi) return response()->json(['errors' => [__('messages.error403')]], 403);
                    return abort(403);
                }
            }
        }
        return $next($request);
    }
}