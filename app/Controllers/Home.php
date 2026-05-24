<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\PanahanGameModel;
use App\Models\PanahanShotModel;

class Home extends BaseController
{
    public function index(): string
    {
        $anggotaModel = new AnggotaModel();
        $gameModel    = new PanahanGameModel();
        $shotModel    = new PanahanShotModel();

        // 1. Fetch count stats
        $totalAthletes = $anggotaModel->countAllResults();
        $totalGames    = $gameModel->countAllResults();
        $totalShots    = $shotModel->countAllResults();

        // 2. Highest Score ever recorded
        $highestScoreRow = $gameModel->orderBy('total_score', 'DESC')->first();
        $highestScore    = $highestScoreRow ? $highestScoreRow['total_score'] : 0;
        
        $highestAthlete = '-';
        if ($highestScoreRow) {
            $athlete = $anggotaModel->find($highestScoreRow['anggota_id']);
            $highestAthlete = $athlete ? $athlete['nama'] : '-';
        }

        // 3. Latest games (limit 4)
        $latestGames = $gameModel->select('panahan_game.*, anggota.nama as nama_anggota')
                                 ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                                 ->orderBy('panahan_game.tanggal', 'DESC')
                                 ->orderBy('panahan_game.id', 'DESC')
                                 ->limit(4)
                                 ->find();

        // 4. Performance trends for chart (latest 6 games)
        $recentGames = $gameModel->select('panahan_game.total_score, panahan_game.tanggal, anggota.nama as nama_anggota')
                                 ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                                 ->orderBy('panahan_game.tanggal', 'ASC')
                                 ->orderBy('panahan_game.id', 'ASC')
                                 ->limit(6)
                                 ->find();

        $chartLabels = [];
        $chartScores = [];
        foreach ($recentGames as $rg) {
            $chartLabels[] = explode(' ', $rg['nama_anggota'])[0] . ' (' . date('d/m', strtotime($rg['tanggal'])) . ')';
            $chartScores[] = $rg['total_score'];
        }

        $data = [
            'title'          => 'Dashboard',
            'active_menu'    => 'dashboard',
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
