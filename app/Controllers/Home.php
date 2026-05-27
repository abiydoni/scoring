<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\PanahanGameModel;
use App\Models\PanahanShotModel;

class Home extends BaseController
{
    public function index()
    {
        $activeCabor = session()->get('active_cabor');
        if (!$activeCabor) {
            return redirect()->to('/sports');
        }

        $anggotaModel = new AnggotaModel();
        
        // 1. Fetch Athletes for Active Cabor
        $totalAthletes = $anggotaModel->where('cabor', $activeCabor)->countAllResults();

        // Defaults for non-implemented modules
        $totalGames = 0;
        $totalShots = 0;
        $highestScore = 0;
        $highestAthlete = '-';
        $latestGames = [];
        $chartLabels = [];
        $chartScores = [];

        // 2. Fetch Module-specific stats
        if (strtolower($activeCabor) === 'panahan') {
            $gameModel = new PanahanGameModel();
            $shotModel = new PanahanShotModel();

            $totalGames = $gameModel->countAllResults();
            $totalShots = $shotModel->countAllResults();

            $highestScoreRow = $gameModel->orderBy('total_score', 'DESC')->first();
            $highestScore    = $highestScoreRow ? $highestScoreRow['total_score'] : 0;
            
            if ($highestScoreRow) {
                $athlete = $anggotaModel->find($highestScoreRow['anggota_id']);
                $highestAthlete = $athlete ? $athlete['nama'] : '-';
            }

            $latestGames = $gameModel->select('panahan_game.*, anggota.nama as nama_anggota')
                                     ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                                     ->orderBy('panahan_game.tanggal', 'DESC')
                                     ->orderBy('panahan_game.id', 'DESC')
                                     ->limit(4)
                                     ->find();

            $recentGames = $gameModel->select('panahan_game.total_score, panahan_game.tanggal, anggota.nama as nama_anggota')
                                     ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                                     ->orderBy('panahan_game.tanggal', 'ASC')
                                     ->orderBy('panahan_game.id', 'ASC')
                                     ->limit(6)
                                     ->find();

            foreach ($recentGames as $rg) {
                $chartLabels[] = explode(' ', $rg['nama_anggota'])[0] . ' (' . date('d/m', strtotime($rg['tanggal'])) . ')';
                $chartScores[] = $rg['total_score'];
            }
        }

        $data = [
            'title'          => 'Dashboard ' . $activeCabor,
            'active_menu'    => 'dashboard',
            'activeCabor'    => $activeCabor,
            'totalAthletes'  => $totalAthletes,
            'totalGames'     => $totalGames,
            'totalShots'     => $totalShots,
            'highestScore'   => $highestScore,
            'highestAthlete' => $highestAthlete,
            'latestGames'    => $latestGames,
            'chartLabels'    => json_encode($chartLabels),
            'chartScores'    => json_encode($chartScores),
        ];

        return view('dashboard', $data);
    }
}
