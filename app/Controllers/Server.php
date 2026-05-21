<?php

namespace App\Controllers;

class Server extends BaseController
{
    public function server_time()
    {
        return $this->response->setJSON([
            'now' => date('Y-m-d H:i:s')
        ]);
    }
}
