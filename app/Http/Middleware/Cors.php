<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{

    public function handle($request, Closure $next)
    {

        //$response= $next($request);  
        $allow_origin = [
            'http://localhost',
            'http://localhost:3000',
            'http://localhost:8000',
            'http://localhost:9000',
            'http://localhost:8080',
        ];

        if(isset($_SERVER['HTTP_ORIGIN']) &&
            in_array($_SERVER['HTTP_ORIGIN'], $allow_origin)) {

            //配置信任的跨域来源
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            //配置允许发送认证信息 比如cookies（会话机制的前提）
            header('Access-Control-Allow-Credentials: true');
            //允许的自定义请求头
            header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Secret');
            //信任跨域有效期，秒为单位
            header('Access-Control-Max-Age: 120');
        }

        //return $response;
        return $next($request); 


        $response = $next($request);
        
        // $httpOrigin = $request->header('Origin');
        // if ($httpOrigin && in_array($httpOrigin, explode(',', env('CORS_DOMAINS')))) {

        //     $response->header('Access-Control-Allow-Origin', $httpOrigin);
        //     $response->header('Access-Control-Allow-Credentials', 'true');
        //     $response->header('Access-Control-Expose-Headers', 'Authorization');

        //     if($request->getMethod() === Request::METHOD_OPTIONS){
        //         $response->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        //         $response->header('Access-Control-Allow-Headers', 'Authorization');
        //     }

        // }

        // return $response;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token, Authorization');
        return $next($request);

        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin' , '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
 
        return $response;
    }
}
