<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\PanahanGameModel;
use App\Models\PanahanShootModel;
use App\Models\PanahanShotModel;

class Panahan extends BaseController
{
    protected $anggotaModel;
    protected $gameModel;
    protected $shootModel;
    protected $shotModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->gameModel    = new PanahanGameModel();
        $this->shootModel   = new PanahanShootModel();
        $this->shotModel    = new PanahanShotModel();
    }

    // 1. Pilih Anggota untuk mulai scoring
    public function index(): string
    {
        $data = [
            'title'       => 'Scoring Panahan',
            'active_menu' => 'scoring',
            'anggota'     => $this->anggotaModel->orderBy('nama', 'ASC')->findAll(),
        ];

        return view('panahan/index', $data);
    }

    // 2. Riwayat game per Anggota
    public function anggota($athleteId): string
    {
        $athlete = $this->anggotaModel->find($athleteId);
        if (!$athlete) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Atlet tidak ditemukan!');
        }

        // Get all athletes EXCEPT current one for the opponent dropdown
        $opponents = $this->anggotaModel->where('id !=', $athleteId)->orderBy('nama', 'ASC')->findAll();

        $data = [
            'title'       => 'History Scoring - ' . explode(' ', $athlete['nama'])[0],
            'active_menu' => 'scoring',
            'show_back'   => true,
            'back_url'    => '/panahan',
            'anggota'     => $athlete,
            'opponents'   => $opponents,
            'games'       => $this->gameModel->getGamesByAthlete($athleteId),
        ];

        return view('panahan/anggota', $data);
    }

    // 3. POST: Create New Game
    public function create()
    {
        $rules = [
            'anggota_id'  => 'required|is_natural_no_zero',
            'tanggal'     => 'required|valid_date[Y-m-d]',
            'tipe_game'   => 'required|in_list[kualifikasi,aduan]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal! Periksa kembali input tanggal dan tipe game.',
            ]);
        }

        $tipeGame = $this->request->getPost('tipe_game');
        
        // If Aduan (Duel), session is always 1 (represented as sets 1-5 inside 1 session), and we parse opponents
        $jumlahSesi = ($tipeGame === 'aduan') ? 1 : intval($this->request->getPost('jumlah_sesi') ?? 2);
        
        $lawanId = null;
        $lawanNama = null;

        if ($tipeGame === 'aduan') {
            $lawanIdInput = $this->request->getPost('lawan_id');
            if ($lawanIdInput && is_numeric($lawanIdInput)) {
                $lawanId = intval($lawanIdInput);
            } else {
                $lawanNama = $this->request->getPost('lawan_nama') ?: 'Lawan';
            }
        }

        $divisi = $this->request->getPost('divisi') ?: 'recurve';

        $gameId = $this->gameModel->insert([
            'anggota_id'        => $this->request->getPost('anggota_id'),
            'tanggal'           => $this->request->getPost('tanggal'),
            'jumlah_sesi'       => $jumlahSesi,
            'tipe_game'         => $tipeGame,
            'lawan_id'          => $lawanId,
            'lawan_nama'        => $lawanNama,
            'total_score'       => 0,
            'total_score_lawan' => 0,
            'set_point_atlet'   => 0,
            'set_point_lawan'   => 0,
            'divisi'            => $divisi,
            'keterangan'        => $this->request->getPost('keterangan'),
        ]);

        if ($gameId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Permainan baru berhasil dibuat!',
                'gameId'  => $gameId,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal membuat permainan di database.',
        ]);
    }

    // 4. Detail Game (Daftar Sesi / Sets)
    public function game($gameId): string
    {
        $game = $this->gameModel->getGameWithAthlete($gameId);
        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Game tidak ditemukan!');
        }

        // Ambil rekap total score per sesi (atlet utama is_lawan = 0)
        $db = \Config\Database::connect();
        $sessionTotals = $db->table('panahan_shoot')
                            ->select('session_number, SUM(total_score) as total_score')
                            ->where('game_id', $gameId)
                            ->where('is_lawan', 0)
                            ->groupBy('session_number')
                            ->get()
                            ->getResultArray();

        // Ambil nama lawan
        $namaLawan = 'Lawan';
        if ($game['tipe_game'] === 'aduan') {
            $namaLawan = $game['lawan_id'] ? $game['nama_lawan_db'] : ($game['lawan_nama'] ?: 'Lawan');
        }

        $data = [
            'title'         => 'Permainan - ' . explode(' ', $game['nama_anggota'])[0],
            'active_menu'   => 'scoring',
            'show_back'     => true,
            'back_url'      => '/panahan/anggota/' . $game['anggota_id'],
            'game'          => $game,
            'sessionTotals' => $sessionTotals,
            'jumlahSesi'    => $game['jumlah_sesi'],
            'namaLawan'     => $namaLawan,
        ];

        return view('panahan/game', $data);
    }

    // 5. Input Lembar Scoring Sesi / Sets
    public function sesi($gameId, $sessionNumber): string
    {
        $game = $this->gameModel->getGameWithAthlete($gameId);
        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Game tidak ditemukan!');
        }

        // Ambil shoot totals (Rambahan 1-6) untuk sesi ini
        $shootTotals = $this->shootModel->getShootTotals($gameId, $sessionNumber);

        // Ambil detail shot (anak panah 1-6) untuk sesi ini
        $shots = $this->shotModel->getShotsForSession($gameId, $sessionNumber);

        // Ambil nama lawan
        $namaLawan = 'Lawan';
        if ($game['tipe_game'] === 'aduan') {
            $namaLawan = $game['lawan_id'] ? $game['nama_lawan_db'] : ($game['lawan_nama'] ?: 'Lawan');
        }

        $data = [
            'title'         => 'Sesi ' . $sessionNumber . ' - ' . explode(' ', $game['nama_anggota'])[0],
            'active_menu'   => 'scoring',
            'show_back'     => true,
            'back_url'      => '/panahan/game/' . $gameId,
            'game'          => $game,
            'sessionNumber' => $sessionNumber,
            'shootTotals'   => $shootTotals,
            'shootData'     => $shots,
            'namaLawan'     => $namaLawan,
        ];

        return view('panahan/sesi', $data);
    }

    // 6. POST AJAX: Save Shoot Scores
    public function saveShoot($gameId)
    {
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
        }

        $sessionNumber = $json->session_number;
        $shootNumber   = $json->shoot_number;
        
        $athleteArrows = $json->athlete_arrows;
        $opponentArrows = $json->opponent_arrows ?? null; // Optional, only for aduan

        $game = $this->gameModel->find($gameId);
        if (!$game) {
            return $this->response->setJSON(['success' => false, 'message' => 'Game tidak ditemukan']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan skor Atlet Utama (is_lawan = 0)
        $athleteShootTotal = 0;
        foreach ($athleteArrows as $arrow) {
            $score = intval($arrow->score);
            $displayValue = $arrow->display_value;
            $arrowNumber = intval($arrow->arrow_number);

            $athleteShootTotal += $score;

            $existing = $this->shotModel->where('game_id', $gameId)
                                        ->where('session_number', $sessionNumber)
                                        ->where('shoot_number', $shootNumber)
                                        ->where('arrow_number', $arrowNumber)
                                        ->where('is_lawan', 0)
                                        ->first();

            if ($existing) {
                $this->shotModel->update($existing['id'], [
                    'score'         => $score,
                    'display_value' => $displayValue,
                ]);
            } else {
                $this->shotModel->insert([
                    'game_id'        => $gameId,
                    'session_number' => $sessionNumber,
                    'shoot_number'   => $shootNumber,
                    'arrow_number'   => $arrowNumber,
                    'score'          => $score,
                    'display_value'  => $displayValue,
                    'is_lawan'       => 0,
                ]);
            }
        }

        // Simpan summary total_score atlet utama di panahan_shoot
        $existingAthleteShoot = $this->shootModel->where('game_id', $gameId)
                                                 ->where('session_number', $sessionNumber)
                                                 ->where('shoot_number', $shootNumber)
                                                 ->where('is_lawan', 0)
                                                 ->first();

        if ($existingAthleteShoot) {
            $this->shootModel->update($existingAthleteShoot['id'], [
                'total_score' => $athleteShootTotal,
            ]);
        } else {
            $this->shootModel->insert([
                'game_id'        => $gameId,
                'session_number' => $sessionNumber,
                'shoot_number'   => $shootNumber,
                'total_score'    => $athleteShootTotal,
                'is_lawan'       => 0,
            ]);
        }

        // 2. Simpan skor Lawan (is_lawan = 1) - Khusus untuk Aduan
        $opponentShootTotal = 0;
        if ($game['tipe_game'] === 'aduan' && $opponentArrows) {
            foreach ($opponentArrows as $arrow) {
                $score = intval($arrow->score);
                $displayValue = $arrow->display_value;
                $arrowNumber = intval($arrow->arrow_number);

                $opponentShootTotal += $score;

                $existing = $this->shotModel->where('game_id', $gameId)
                                            ->where('session_number', $sessionNumber)
                                            ->where('shoot_number', $shootNumber)
                                            ->where('arrow_number', $arrowNumber)
                                            ->where('is_lawan', 1)
                                            ->first();

                if ($existing) {
                    $this->shotModel->update($existing['id'], [
                        'score'         => $score,
                        'display_value' => $displayValue,
                    ]);
                } else {
                    $this->shotModel->insert([
                        'game_id'        => $gameId,
                        'session_number' => $sessionNumber,
                        'shoot_number'   => $shootNumber,
                        'arrow_number'   => $arrowNumber,
                        'score'          => $score,
                        'display_value'  => $displayValue,
                        'is_lawan'       => 1,
                    ]);
                }
            }

            // Simpan summary total_score lawan di panahan_shoot
            $existingOpponentShoot = $this->shootModel->where('game_id', $gameId)
                                                      ->where('session_number', $sessionNumber)
                                                      ->where('shoot_number', $shootNumber)
                                                      ->where('is_lawan', 1)
                                                      ->first();

            if ($existingOpponentShoot) {
                $this->shootModel->update($existingOpponentShoot['id'], [
                    'total_score' => $opponentShootTotal,
                ]);
            } else {
                $this->shootModel->insert([
                    'game_id'        => $gameId,
                    'session_number' => $sessionNumber,
                    'shoot_number'   => $shootNumber,
                    'total_score'    => $opponentShootTotal,
                    'is_lawan'       => 1,
                ]);
            }
        }

        // 3. Rekalkulasi Game Total Score & Set Points
        if ($game['tipe_game'] === 'aduan') {
            // Hitung akumulatif skor tembakan
            $athleteTotalScoreRow = $this->shootModel->select('SUM(total_score) as grand_total')
                                                     ->where('game_id', $gameId)
                                                     ->where('is_lawan', 0)
                                                     ->first();
            $athleteTotalScore = $athleteTotalScoreRow ? intval($athleteTotalScoreRow['grand_total']) : 0;

            $opponentTotalScoreRow = $this->shootModel->select('SUM(total_score) as grand_total')
                                                       ->where('game_id', $gameId)
                                                       ->where('is_lawan', 1)
                                                       ->first();
            $opponentTotalScore = $opponentTotalScoreRow ? intval($opponentTotalScoreRow['grand_total']) : 0;

            // Hitung Poin Set (Set Points) untuk setiap set (Rambahan 1 s.d. 5) - Hanya jika bukan divisi Compound
            $setPointAtlet = 0;
            $setPointLawan = 0;

            if ($game['divisi'] !== 'compound') {
                for ($s = 1; $s <= 5; $s++) {
                    $atletSet = $this->shootModel->where('game_id', $gameId)
                                                 ->where('session_number', $sessionNumber)
                                                 ->where('shoot_number', $s)
                                                 ->where('is_lawan', 0)
                                                 ->first();
                    
                    $lawanSet = $this->shootModel->where('game_id', $gameId)
                                                 ->where('session_number', $sessionNumber)
                                                 ->where('shoot_number', $s)
                                                 ->where('is_lawan', 1)
                                                 ->first();

                    if ($atletSet && $lawanSet) {
                        $atletScore = intval($atletSet['total_score']);
                        $lawanScore = intval($lawanSet['total_score']);

                        if ($atletScore > $lawanScore) {
                            $setPointAtlet += 2;
                        } elseif ($atletScore === $lawanScore) {
                            $setPointAtlet += 1;
                            $setPointLawan += 1;
                        } else {
                            $setPointLawan += 2;
                        }
                    }
                }
            }

            // Simpan semua hitungan kumulatif ke panahan_game
            $this->gameModel->update($gameId, [
                'total_score'       => $athleteTotalScore,
                'total_score_lawan' => $opponentTotalScore,
                'set_point_atlet'   => $setPointAtlet,
                'set_point_lawan'   => $setPointLawan,
            ]);

        } else {
            // Jika kualifikasi biasa, cukup hitung total skor atlet utama
            $athleteTotalScoreRow = $this->shootModel->select('SUM(total_score) as grand_total')
                                                     ->where('game_id', $gameId)
                                                     ->where('is_lawan', 0)
                                                     ->first();
            $athleteTotalScore = $athleteTotalScoreRow ? intval($athleteTotalScoreRow['grand_total']) : 0;

            $this->gameModel->update($gameId, [
                'total_score' => $athleteTotalScore,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data scoring panahan.',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Scoring shoot ' . $shootNumber . ' berhasil disimpan!',
        ]);
    }
}
