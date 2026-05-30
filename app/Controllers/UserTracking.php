<?php

namespace App\Controllers;

use App\Models\AppUserModel;

class UserTracking extends BaseController
{
    public function record_online()
    {
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $picture = $this->request->getPost('picture');

        if (!$email) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email is required']);
        }

        $userModel = new AppUserModel();
        
        $user = $userModel->where('email', $email)->first();
        
        $data = [
            'email' => $email,
            'last_online' => date('Y-m-d H:i:s')
        ];

        if ($name) $data['name'] = $name;
        if ($picture) $data['picture'] = $picture;

        if ($user) {
            $userModel->update($user['id'], $data);
        } else {
            $userModel->insert($data);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $userModel = new AppUserModel();
        $userModel->delete($id);
        return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
    }

    public function clearAll()
    {
        $db = \Config\Database::connect();
        $db->table('app_users')->truncate();
        return redirect()->to('/users')->with('success', 'Semua data user berhasil dihapus.');
    }


    public function index()
    {
        $userModel = new AppUserModel();
        $users = $userModel->orderBy('last_online', 'DESC')->findAll();

        $data = [
            'title' => 'Pengguna Aktif',
            'active_menu' => 'users',
            'users' => $users,
            'hide_ganti_cabor' => true,
            'hide_bottom_nav' => true,
            'show_back' => true,
            'back_url' => '/sports'
        ];

        return view('users/index', $data);
    }
}
