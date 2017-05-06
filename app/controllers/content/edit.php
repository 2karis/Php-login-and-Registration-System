<?php 

namespace App\controllers\content; 

class edit extends controller{
    public function getEdit($request, $response){  
        return $this->view->render($response, 'content/edit.html');
    }   
}