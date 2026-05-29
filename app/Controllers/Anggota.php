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

    private function handleUpload($id = null)
    {
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $uploadPath = FCPATH . 'uploads/anggota';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Hapus foto lama jika sedang update
            if ($id) {
                $oldData = $this->anggotaModel->find($id);
                if ($oldData && !empty($oldData['foto']) && file_exists($uploadPath . '/' . $oldData['foto'])) {
                    unlink($uploadPath . '/' . $oldData['foto']);
                }
            }
            
            // Pindahkan file
            $foto->move($uploadPath, $namaFoto);
            
            // Resize dan kompres otomatis menjadi persegi 300x300
            try {
                \Config\Services::image()
                    ->withFile($uploadPath . '/' . $namaFoto)
                    ->fit(300, 300, 'center')
                    ->save($uploadPath . '/' . $namaFoto, 75);
            } catch (\Exception $e) {
                // Abaikan jika library GD tidak aktif, biarkan original
            }
            
            return $namaFoto;
        }
        
        return false;
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

        $namaFoto = $this->handleUpload();

        $this->anggotaModel->save([
            'cabor'         => session()->get('active_cabor') ?: 'Panahan',
            'nama'          => $this->request->getPost('nama'),
            'telepon'       => $this->request->getPost('telepon'),
            'email'         => $this->request->getPost('email'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'divisi'        => $this->request->getPost('divisi'),
            'klub'          => $this->request->getPost('klub'),
            'kota'          => $this->request->getPost('kota'),
            'foto'          => $namaFoto ?: null,
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

        $namaFoto = $this->handleUpload($id);
        
        $data = [
            'cabor'         => session()->get('active_cabor') ?: 'Panahan',
            'nama'          => $this->request->getPost('nama'),
            'telepon'       => $this->request->getPost('telepon'),
            'email'         => $this->request->getPost('email'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'divisi'        => $this->request->getPost('divisi'),
            'klub'          => $this->request->getPost('klub'),
            'kota'          => $this->request->getPost('kota'),
        ];
        
        if ($namaFoto !== false) {
            $data['foto'] = $namaFoto;
        }

        $this->anggotaModel->update($id, $data);

        return redirect()->to('/anggota')->with('success', 'Data atlet berhasil diubah!');
    }

    // Delete athlete
    public function delete($id)
    {
        // Delete photo if exists
        $oldData = $this->anggotaModel->find($id);
        if ($oldData && !empty($oldData['foto']) && file_exists(FCPATH . 'uploads/anggota/' . $oldData['foto'])) {
            unlink(FCPATH . 'uploads/anggota/' . $oldData['foto']);
        }
        
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota')->with('success', 'Atlet berhasil dihapus!');
    }
}
