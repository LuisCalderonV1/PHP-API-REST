<?php
class Middleware
{
    public function checkAccess($access)
    {
        $token = Request::getBearerToken();
        
        if(Auth::Check($token)){

            if(Auth::getData($token)->rol_id < $access['min_required'] ){

                header("HTTP/1.1 404 Not Found");
                echo json_encode(['name' => 'Bad Credentials', 'details' => ['issue' => 'INVALID_CREDENTIALS',
                'description'=> 'Permission denied']]);

                exit;
            }

        }
    }

}
