<?php
namespace App\Middleware;
class AuthMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		if(!$this->container->auth->check()){
			$this->container->flash->addmessage('error', 'please sign in before doing that.');
			return $response->withRedirect($this->container->router->pathFor('home'));

    	}
      	
		$response = $next($request, $response);
		return $response;
	}
}
