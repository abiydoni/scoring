<?php

namespace App\Controllers;

class Sports extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'       => 'Cabang Olahraga',
            'active_menu' => 'scoring',
        ];

        return view('sports', $data);
    }
}
