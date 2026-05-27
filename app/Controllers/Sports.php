<?php

namespace App\Controllers;

class Sports extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'            => 'Pilih Cabang Olahraga',
            'active_menu'      => 'scoring', // Highlight scoring tab since it's the entry point
            'hide_ganti_cabor' => true,
            'hide_bottom_nav'  => true,
        ];

        return view('sports', $data);
    }

    public function select($cabor)
    {
        // Save the chosen sport to session
        session()->set('active_cabor', ucfirst($cabor));
        
        // Redirect to dashboard
        return redirect()->to('/');
    }
}
