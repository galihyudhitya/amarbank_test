<?php

namespace src\Http;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator 
{
    protected $errors;

    public function validate($request, array $rules) 
    {
        foreach($rules as $field => $rule) 
        {
            try 
            {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch (NestedValidationException $e) 
            {
                $this->errors[$field] = $e->getMessages();
                // if ($field == 'KTP Number') {
                //     $this->errors[$field] = "Berhasil";
                // }
            }
        }

        var_dump($this->errors);

        if (!empty($this->errors)) {
            die();
        }
    }


    public function failed()
    {
        return !empty($this->errors);
    }
}