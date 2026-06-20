<?php

namespace App\Controllers;

class Error extends BaseController
{
    public function unauthorized()
    {
        return response()
            ->setStatusCode(403)
            ->setBody(view('errors/unauthorized'));
    }
}