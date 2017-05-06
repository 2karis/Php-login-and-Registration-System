<?php 

namespace App\controllers\content; 

class content extends controller{
    public function getContent($request, $response){  
        return $this->view->render($response, 'content/content.html');
    }   
}