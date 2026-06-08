<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // If roles are specified
        if (!empty($arguments)) {
            $role_id = (string) session()->get('role_id');

            if (!in_array($role_id, $arguments)) {
                return response()
                ->setStatusCode(403)
                ->setBody(view('errors/unauthorized', [
                    'backUrl' => previous_url() ?? base_url('/')
                ]));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}