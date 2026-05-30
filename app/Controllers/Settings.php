<?php

namespace App\Controllers;

class Settings extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan',
            'active_menu' => 'users', // Keep users active in bottom nav? Or settings if it existed.
            'hide_ganti_cabor' => true,
            'hide_bottom_nav' => true,
            'show_back' => true,
            'back_url' => '/users'
        ];

        return view('settings/index', $data);
    }

    public function backup()
    {
        $dbPath = WRITEPATH . 'scoring.sqlite';
        
        if (!file_exists($dbPath)) {
            return redirect()->back()->with('error', 'Database file tidak ditemukan.');
        }

        $filename = 'backup_scoring_' . date('Y-m-d_H-i-s') . '.sqlite';
        
        return $this->response->download($dbPath, null)->setFileName($filename);
    }
}
