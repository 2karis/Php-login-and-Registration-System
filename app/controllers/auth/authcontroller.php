<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\controllers\auth; 
use App\Models\User;
use App\controllers\controller;
use Respect\Validation\Validator as v;

class authController extends controller{
    
    public function getsignout($request, $response){
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }    

    public function getsignup($request, $response){
        
        return $this->view->render($response, 'auth/signup.html');
    }
    
    public function postsignup($request, $response){
		    	
		$Validation = $this->validator->validate($request, [
                'email'=>v::notEmpty()->noWhitespace()->email()->EmailAvailable(),
                'username'=>v::notEmpty()->alpha(),
                'password'=>v::notEmpty()->noWhitespace(),
            ]);

        if($this->validator->failed()){
            //redirect back
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }
		
        $user = User::create([
        		'username'=> $request->getParam('username'),
        		'email'=> $request->getParam('email') ,
        		'password'=> password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        	]);
        $auth =  $this->auth->attempt($user->email, $request->getParam('password'));

        $this->flash->addMessage('info', 'You have signed up Successfully!');
        return $response->withRedirect($this->router->pathFor('home'));
    }
    public function getSignIn($request, $response){
         return $this->view->render($response, 'auth/signin.html');
    }
    public function postSignIn($request, $response){
        $auth =  $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password'));
        if(!$auth){
            $this->flash->addMessage('error', 'Could not Sign You in!');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getChangePassword($request, $response){
        return $this->view->render($response, 'auth/changePassword.html');
    }
     public function postChangePassword($request, $response){
        $validation = $this->validator->validate($request, [
                'password_old'=>v::noWhitespace()->notEmpty()->MatchesPassword($this->auth->user()->password),
                'password_new'=> v::noWhitespace()->notEmpty(),
            ]);
        if($this->validator->failed()){
            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }
       
        $this->auth->user()->update([
            'password'=>password_hash($request->getParam('password_new'), PASSWORD_DEFAULT)
        ]);
        $this->flash->addMessage('info', 'Your password was Changed.');

        return $response->withRedirect($this->router->pathFor('home'));
        
    }



     
}
