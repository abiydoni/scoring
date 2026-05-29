<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\PanahanGameModel;
use App\Models\PanahanShotModel;
use App\Models\BulutangkisMatchModel;
use App\Models\BulutangkisGameModel;

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
        
        // Extended defaults for Panahan
        $avgScore = 0;
        $winRate = ['menang' => 0, 'kalah' => 0, 'seri' => 0, 'total' => 0];
        $arrowLabels = [];
        $arrowData = [];
        $topAthleteLabels = [];
        $topAthleteData = [];

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

            // --- NEW PANAHAN STATS ---
            // Rata-rata Skor per Game
            $avgScoreRow = $gameModel->select('AVG(total_score) as avg_score')->first();
            $avgScore = $avgScoreRow ? round($avgScoreRow['avg_score'], 1) : 0;

            // Statistik Menang/Kalah/Seri
            $matches = $gameModel->where('tipe_game', 'Tanding')->findAll();
            $menang = 0; $kalah = 0; $seri = 0;
            foreach ($matches as $m) {
                if ($m['set_point_atlet'] > $m['set_point_lawan']) $menang++;
                elseif ($m['set_point_atlet'] < $m['set_point_lawan']) $kalah++;
                else $seri++;
            }
            $winRate = [
                'menang' => $menang,
                'kalah' => $kalah,
                'seri' => $seri,
                'total' => count($matches)
            ];

            // Distribusi Anak Panah
            $arrowDist = $shotModel->select('display_value, COUNT(*) as count')
                                   ->where('is_lawan', 0)
                                   ->groupBy('display_value')
                                   ->findAll();
            
            // Sort Arrow Distribution manually (X, 10, 9, ..., M)
            $order = ['X' => 11, '10' => 10, '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2, '1' => 1, 'M' => 0];
            usort($arrowDist, function($a, $b) use ($order) {
                $valA = $order[$a['display_value']] ?? -1;
                $valB = $order[$b['display_value']] ?? -1;
                return $valB - $valA;
            });

            foreach ($arrowDist as $ad) {
                $arrowLabels[] = $ad['display_value'];
                $arrowData[] = $ad['count'];
            }

            // Top 5 Atlet berdasarkan rata-rata skor
            $topAthletes = $gameModel->select('anggota.nama, AVG(panahan_game.total_score) as avg_score')
                                     ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                                     ->groupBy('panahan_game.anggota_id')
                                     ->orderBy('avg_score', 'DESC')
                                     ->limit(5)
                                     ->find();
            
            foreach ($topAthletes as $ta) {
                $topAthleteLabels[] = explode(' ', $ta['nama'])[0];
                $topAthleteData[] = round($ta['avg_score'], 1);
            }

        } else if (strtolower($activeCabor) === 'bulutangkis') {
            $bmModel = new BulutangkisMatchModel();
            $bgModel = new BulutangkisGameModel();

            $totalGames = $bmModel->countAllResults();
            $totalShots = $bgModel->countAllResults(); // we map 'shots' to 'games/sets' for bulutangkis stats

            $latestGames = $bmModel->select('bulutangkis_match.*, anggota.nama as nama_anggota')
                                     ->join('anggota', 'anggota.id = bulutangkis_match.anggota_id')
                                     ->orderBy('bulutangkis_match.tanggal', 'DESC')
                                     ->orderBy('bulutangkis_match.id', 'DESC')
                                     ->limit(4)
                                     ->find();
                                     
            $recentMatches = $bmModel->select('bulutangkis_match.*, anggota.nama as nama_anggota')
                                     ->join('anggota', 'anggota.id = bulutangkis_match.anggota_id')
                                     ->orderBy('bulutangkis_match.tanggal', 'ASC')
                                     ->orderBy('bulutangkis_match.id', 'ASC')
                                     ->limit(6)
                                     ->find();

            foreach ($recentMatches as $rm) {
                $chartLabels[] = explode(' ', $rm['nama_anggota'])[0] . ' (' . date('d/m', strtotime($rm['tanggal'])) . ')';
                $chartScores[] = $rm['set_menang_atlet'];
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
            // Extensions
            'avgScore'         => $avgScore,
            'winRate'          => $winRate,
            'arrowLabels'      => json_encode($arrowLabels),
            'arrowData'        => json_encode($arrowData),
            'topAthleteLabels' => json_encode($topAthleteLabels),
            'topAthleteData'   => json_encode($topAthleteData),
        ];

        return view('dashboard', $data);
    }
}
