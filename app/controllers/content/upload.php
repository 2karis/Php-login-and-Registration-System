<?php 

namespace App\controllers\content; 

class upload extends controller{
    public function getUpload($request, $response){  
        return $this->view->render($response, 'content/upload.html');
    }   
}