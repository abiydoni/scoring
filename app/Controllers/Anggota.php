<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    // List athletes
    public function index(): string
    {
        $data = [
            'title'       => 'Daftar Atlet',
            'active_menu' => 'anggota',
            'anggota'     => $this->anggotaModel->orderBy('nama', 'ASC')->findAll(),
        ];

        return view('anggota/index', $data);
    }

    // Store new athlete
    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Nama atlet minimal 3 karakter!');
        }

        $this->anggotaModel->save([
            'nama'       => $this->request->getPost('nama'),
            'telepon'    => $this->request->getPost('telepon'),
            'email'      => $this->request->getPost('email'),
            'asal_klub'  => $this->request->getPost('asal_klub'),
        ]);

        return redirect()->to('/anggota')->with('success', 'Atlet berhasil ditambahkan!');
    }

    // Update athlete details
    public function update($id)
    {
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Nama atlet minimal 3 karakter!');
        }

        $this->anggotaModel->update($id, [
            'nama'       => $this->request->getPost('nama'),
            'telepon'    => $this->request->getPost('telepon'),
            'email'      => $this->request->getPost('email'),
            'asal_klub'  => $this->request->getPost('asal_klub'),
        ]);

        return redirect()->to('/anggota')->with('success', 'Data atlet berhasil diubah!');
    }

    // Delete athlete
    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota')->with('success', 'Atlet berhasil dihapus!');
    }
}
