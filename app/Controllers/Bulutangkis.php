<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\BulutangkisMatchModel;
use App\Models\BulutangkisGameModel;

class Bulutangkis extends BaseController
{
    protected $anggotaModel;
    protected $matchModel;
    protected $gameModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->matchModel = new BulutangkisMatchModel();
        $this->gameModel = new BulutangkisGameModel();
    }

    protected function checkCabor()
    {
        $activeCabor = session()->get('active_cabor');
        if (!$activeCabor || strtolower($activeCabor) !== 'bulutangkis') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkCabor()) {
            return redirect()->to('/sports')->with('error', 'Silakan pilih cabang olahraga Bulutangkis terlebih dahulu.');
        }

        $data = [
            'title' => 'Scoring Bulutangkis',
            'anggota' => $this->anggotaModel->where('cabor', 'Bulutangkis')->findAll(),
            'active_menu' => 'scoring'
        ];

        return view('bulutangkis/index', $data);
    }

    public function riwayat($id)
    {
        if (!$this->checkCabor()) {
            return redirect()->to('/sports');
        }

        $atlet = $this->anggotaModel->find($id);
        if (!$atlet) {
            return redirect()->to('/bulutangkis')->with('error', 'Atlet tidak ditemukan.');
        }

        $matches = $this->matchModel
            ->select('bulutangkis_match.*, p1.nama as partner_nama_db, p2.nama as lawan_partner_nama_db')
            ->join('anggota p1', 'p1.id = bulutangkis_match.partner_id', 'left')
            ->join('anggota p2', 'p2.id = bulutangkis_match.lawan_partner_id', 'left')
            ->where('anggota_id', $id)
            ->orderBy('tanggal', 'DESC')
            ->orderBy('bulutangkis_match.id', 'DESC')
            ->findAll();
        
        // Ambil semua atlet lain untuk pilihan lawan
        $calon_lawan = $this->anggotaModel->where('cabor', 'Bulutangkis')->where('id !=', $id)->findAll();

        $data = [
            'title' => 'Riwayat Pertandingan',
            'atlet' => $atlet,
            'matches' => $matches,
            'calon_lawan' => $calon_lawan,
            'active_menu' => 'scoring'
        ];

        return view('bulutangkis/riwayat', $data);
    }

    public function create()
    {
        if (!$this->checkCabor()) {
            return redirect()->to('/sports');
        }

        $anggota_id = $this->request->getPost('anggota_id');
        $lawan_id = $this->request->getPost('lawan_id');
        $lawan_nama = $this->request->getPost('lawan_nama');
        $tipe_match = $this->request->getPost('tipe_match');
        
        $partner_id = $this->request->getPost('partner_id') ?: null;
        $lawan_partner_id = $this->request->getPost('lawan_partner_id') ?: null;
        $lawan_partner_nama = $this->request->getPost('lawan_partner_nama');

        // Jika tipe match bukan ganda, null-kan partner
        if ($tipe_match !== 'Ganda') {
            $partner_id = null;
            $lawan_partner_id = null;
            $lawan_partner_nama = null;
        }

        // Jika lawan_id kosong, pastikan lawan_nama ada
        if (empty($lawan_id)) {
            $lawan_id = null;
        } else {
            // Jika lawan terdaftar dipilih, kita bisa ambil namanya
            $lawan = $this->anggotaModel->find($lawan_id);
            if ($lawan) {
                $lawan_nama = $lawan['nama'];
            }
            // Begitu juga untuk partner lawan
            if (!empty($lawan_partner_id)) {
                $l_partner = $this->anggotaModel->find($lawan_partner_id);
                if ($l_partner) {
                    $lawan_partner_nama = $l_partner['nama'];
                }
            }
        }

        $matchData = [
            'anggota_id' => $anggota_id,
            'partner_id' => $partner_id,
            'tanggal' => date('Y-m-d'),
            'tipe_match' => $tipe_match,
            'lawan_id' => $lawan_id,
            'lawan_nama' => $lawan_nama,
            'lawan_partner_id' => $lawan_partner_id,
            'lawan_partner_nama' => $lawan_partner_nama,
            'set_menang_atlet' => 0,
            'set_menang_lawan' => 0,
            'status' => 'ongoing'
        ];

        $this->matchModel->insert($matchData);
        $match_id = $this->matchModel->getInsertID();

        // Buat Set Pertama (Game 1)
        $gameData = [
            'match_id' => $match_id,
            'set_ke' => 1,
            'poin_atlet' => 0,
            'poin_lawan' => 0,
            'is_finished' => false
        ];
        $this->gameModel->insert($gameData);

        return redirect()->to('/bulutangkis/scoring/' . $match_id);
    }

    public function scoring($match_id)
    {
        if (!$this->checkCabor()) {
            return redirect()->to('/sports');
        }

        $match = $this->matchModel->find($match_id);
        if (!$match) {
            return redirect()->to('/bulutangkis')->with('error', 'Pertandingan tidak ditemukan.');
        }

        $atlet = $this->anggotaModel->find($match['anggota_id']);
        
        $partner = null;
        if (!empty($match['partner_id'])) {
            $partner = $this->anggotaModel->find($match['partner_id']);
        }
        
        // Ambil game yang belum selesai, atau game terakhir jika semua selesai
        $currentGame = $this->gameModel->where('match_id', $match_id)->where('is_finished', false)->orderBy('set_ke', 'DESC')->first();
        if (!$currentGame) {
            $currentGame = $this->gameModel->where('match_id', $match_id)->orderBy('set_ke', 'DESC')->first();
        }

        // Ambil semua game untuk history set di bagian atas
        $allGames = $this->gameModel->where('match_id', $match_id)->orderBy('set_ke', 'ASC')->findAll();

        $data = [
            'title' => 'Scoreboard Bulutangkis',
            'match' => $match,
            'atlet' => $atlet,
            'partner' => $partner,
            'currentGame' => $currentGame,
            'allGames' => $allGames,
            // Sembunyikan navigasi bawah agar layar luas untuk scoring
            'hide_bottom_nav' => true
        ];

        return view('bulutangkis/scoring', $data);
    }

    public function update_score()
    {
        if (!$this->checkCabor()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesi tidak valid']);
        }

        $game_id = $this->request->getPost('game_id');
        $player = $this->request->getPost('player'); // 'atlet' atau 'lawan'
        $action = $this->request->getPost('action'); // 'plus' atau 'minus'

        $game = $this->gameModel->find($game_id);
        if (!$game) {
            return $this->response->setJSON(['success' => false, 'message' => 'Game tidak ditemukan']);
        }
        
        if ($game['is_finished']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Set sudah selesai']);
        }

        $poin_atlet = (int)$game['poin_atlet'];
        $poin_lawan = (int)$game['poin_lawan'];

        if ($action == 'plus') {
            if (($poin_atlet >= 21 && $poin_atlet - $poin_lawan >= 2) || 
                ($poin_lawan >= 21 && $poin_lawan - $poin_atlet >= 2) || 
                $poin_atlet >= 30 || $poin_lawan >= 30) {
                return $this->response->setJSON(['success' => false, 'message' => 'Set sudah selesai, poin maksimal telah tercapai.']);
            }
            
            if ($player == 'atlet') {
                $poin_atlet++;
            } else {
                $poin_lawan++;
            }
        } else if ($action == 'minus') {
            if ($player == 'atlet' && $poin_atlet > 0) {
                $poin_atlet--;
            } else if ($player == 'lawan' && $poin_lawan > 0) {
                $poin_lawan--;
            }
        }

        $this->gameModel->update($game_id, [
            'poin_atlet' => $poin_atlet,
            'poin_lawan' => $poin_lawan
        ]);

        return $this->response->setJSON([
            'success' => true, 
            'poin_atlet' => $poin_atlet, 
            'poin_lawan' => $poin_lawan
        ]);
    }

    public function finish_game()
    {
        $game_id = $this->request->getPost('game_id');
        $game = $this->gameModel->find($game_id);
        if (!$game) {
            return $this->response->setJSON(['success' => false, 'message' => 'Game tidak ditemukan']);
        }

        $this->gameModel->update($game_id, ['is_finished' => true]);

        // Update Set win di match
        $match = $this->matchModel->find($game['match_id']);
        if ($game['poin_atlet'] > $game['poin_lawan']) {
            $this->matchModel->update($match['id'], ['set_menang_atlet' => $match['set_menang_atlet'] + 1]);
        } else if ($game['poin_lawan'] > $game['poin_atlet']) {
            $this->matchModel->update($match['id'], ['set_menang_lawan' => $match['set_menang_lawan'] + 1]);
        }

        // Cek apakah perlu tambah set baru
        $matchUpdated = $this->matchModel->find($match['id']);
        if ($matchUpdated['set_menang_atlet'] < 2 && $matchUpdated['set_menang_lawan'] < 2) {
            // Belum ada yang menang 2 set (best of 3), tambah set baru
            $newGameData = [
                'match_id' => $match['id'],
                'set_ke' => $game['set_ke'] + 1,
                'poin_atlet' => 0,
                'poin_lawan' => 0,
                'is_finished' => false
            ];
            $this->gameModel->insert($newGameData);
        } else {
            // Seseorang memenangkan match
            $this->matchModel->update($match['id'], ['status' => 'finished']);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
