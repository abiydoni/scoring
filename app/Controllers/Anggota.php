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
    public function index()
    {
        $activeCabor = session()->get('active_cabor');
        if (!$activeCabor) {
            return redirect()->to('/sports');
        }

        $data = [
            'title'       => 'Daftar Atlet ' . $activeCabor,
            'active_menu' => 'anggota',
            'activeCabor' => $activeCabor,
            'anggota'     => $this->anggotaModel->where('cabor', $activeCabor)->orderBy('nama', 'ASC')->findAll(),
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
            'cabor'         => session()->get('active_cabor') ?: 'Panahan',
            'nama'          => $this->request->getPost('nama'),
            'telepon'       => $this->request->getPost('telepon'),
            'email'         => $this->request->getPost('email'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'divisi'        => $this->request->getPost('divisi'),
            'klub'          => $this->request->getPost('klub'),
            'kota'          => $this->request->getPost('kota'),
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
            'cabor'         => session()->get('active_cabor') ?: 'Panahan',
            'nama'          => $this->request->getPost('nama'),
            'telepon'       => $this->request->getPost('telepon'),
            'email'         => $this->request->getPost('email'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'divisi'        => $this->request->getPost('divisi'),
            'klub'          => $this->request->getPost('klub'),
            'kota'          => $this->request->getPost('kota'),
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
