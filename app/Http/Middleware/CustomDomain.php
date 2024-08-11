<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\Project;


class CustomDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = $request->getHTTPHost();
        // domain main
        if ($domain == getAppDomain()) {

            $request->merge([
                'domain' => $domain,
            ]);
            return $next($request);
        }
        
        // check domain customize landing page
        $page = Project::where('custom_domain', $domain)
                        ->orWhere('sub_domain', $domain)->first();

                       
                        
        // Append domain and tenant to the Request object
        $request->merge([
            'domain' => $domain,
            'page' => $page
        ]);

        return $next($request);
    }
}