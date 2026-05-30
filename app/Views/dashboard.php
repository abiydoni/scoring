<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Welcome Panel -->
<?php $isPanahan = strtolower($activeCabor) === 'panahan'; ?>
<div class="mb-6 p-5 bg-gradient-to-br from-<?= $isPanahan ? 'brand' : 'emerald' ?>-600 to-<?= $isPanahan ? 'indigo' : 'teal' ?>-700 rounded-3xl relative overflow-hidden shadow-lg shadow-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/10 border border-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/20 select-none light-panel dashboard-welcome-card">
    <!-- Abstract Design Background Shapes -->
    <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute -left-6 -top-6 w-24 h-24 bg-<?= $isPanahan ? 'brand' : 'emerald' ?>-400/20 rounded-full blur-xl"></div>
    
    <div class="relative z-10">
        <span class="text-xs font-semibold text-<?= $isPanahan ? 'brand' : 'emerald' ?>-200 tracking-wider uppercase">Scoring App</span>
        <h2 class="text-2xl font-black text-white mt-1 leading-tight">Selamat Datang, Pelatih!</h2>
        <p class="text-xs text-<?= $isPanahan ? 'brand' : 'emerald' ?>-100/90 mt-1.5 leading-relaxed font-light">Monitor perkembangan skor dan rekor performa latihan atlet <?= esc(strtolower($activeCabor)) ?> dengan mudah dan presisi.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-3 gap-2.5 mb-6">
    <!-- Stat Item: Active Athletes -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-blue-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx bx-group text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none"><?= $totalAthletes ?></span>
        <span class="text-[9px] font-bold text-blue-100/80 uppercase tracking-wider mt-1">Atlet</span>
    </div>

    <!-- Stat Item: Total Sesi Game -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-700 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-indigo-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx bx-trophy text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none"><?= $totalGames ?></span>
        <span class="text-[9px] font-bold text-indigo-100/80 uppercase tracking-wider mt-1">Game</span>
    </div>

    <!-- Stat Item: Total Shots -->
    <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-amber-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx <?= $isPanahan ? 'bx-target-lock' : 'bx-tennis-ball' ?> text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none"><?= $totalShots ?></span>
        <span class="text-[9px] font-bold text-amber-100/80 uppercase tracking-wider mt-1"><?= $isPanahan ? 'Panah' : 'Set' ?></span>
    </div>

    <!-- Stat Item: Highest Score -->
    <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-emerald-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx bx-star text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none truncate w-full" title="<?= esc($highestAthlete) ?>"><?= $highestScore ?></span>
        <span class="text-[9px] font-bold text-emerald-100/80 uppercase tracking-wider mt-1">Skor Max</span>
    </div>

    <?php if ($isPanahan): ?>
    <!-- Stat Item: Average Score -->
    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-pink-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx bx-line-chart text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none"><?= $avgScore ?></span>
        <span class="text-[9px] font-bold text-pink-100/80 uppercase tracking-wider mt-1">Avg Skor</span>
    </div>

    <!-- Stat Item: Win Rate -->
    <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-2.5 rounded-2xl flex flex-col items-center text-center justify-center shadow-lg shadow-cyan-500/20 relative overflow-hidden group hover:scale-105 transition-transform">
        <div class="absolute -right-3 -top-3 w-12 h-12 bg-white/20 rounded-full blur-md"></div>
        <i class='bx bx-medal text-[26px] text-white/90 mb-1 drop-shadow-md'></i>
        <span class="text-lg font-black text-white leading-none"><?= $winRate['menang'] ?><span class="text-xs opacity-75">/<?= $winRate['total'] ?></span></span>
        <span class="text-[9px] font-bold text-cyan-100/80 uppercase tracking-wider mt-1">Menang</span>
    </div>
    <?php endif; ?>
</div>

<!-- Performance Charts -->
<?php if ($isPanahan): ?>
<div class="space-y-4 mb-6">
    <!-- Chart 1: Tren Skor Terkini -->
    <div class="p-4 bg-slate-850 border border-slate-800/90 rounded-3xl select-none relative overflow-hidden">
        <div class="flex justify-between items-center mb-4 relative z-10">
            <div>
                <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Tren Skor Terkini</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Riwayat skor dari 6 game terakhir</p>
            </div>
            <span class="text-[10px] px-2.5 py-1 bg-brand-500/10 text-brand-400 border border-brand-500/20 rounded-full font-bold">PANAHAN</span>
        </div>
        <div class="w-full relative h-40 z-10">
            <?php if ($totalGames > 0): ?>
                <canvas id="dashboardChart"></canvas>
            <?php else: ?>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 text-xs">
                    <i class='bx bx-line-chart text-3xl text-slate-600 mb-2'></i>
                    <span>Belum ada data game</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Chart 2: Distribusi Anak Panah (Archery Target Replica) -->
    <div class="p-5 bg-slate-850 border border-slate-800/90 rounded-3xl select-none relative overflow-hidden">
        <div class="flex justify-between items-center mb-6 relative z-10">
            <div>
                <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Akurasi Tembakan</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Perolehan nilai pada papan target</p>
            </div>
            <div class="w-8 h-8 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-400 border border-orange-500/20">
                <i class='bx bx-target-lock text-lg'></i>
            </div>
        </div>
        
        <?php if ($totalShots > 0): ?>
            <?php
                // Process arrow counts
                $counts = [];
                $lbls = json_decode($arrowLabels);
                $dta = json_decode($arrowData);
                if ($lbls && $dta) {
                    foreach ($lbls as $idx => $lbl) {
                        $counts[$lbl] = $dta[$idx];
                    }
                }
                $getCount = function($lbl) use ($counts) {
                    return isset($counts[$lbl]) ? $counts[$lbl] : 0;
                };
            ?>
            <div class="flex flex-col items-center">
                <!-- The Physical Target Graphic -->
                <!-- The Physical Target Graphic -->
                <div class="relative w-56 h-56 md:w-64 md:h-64 rounded-full shadow-2xl shadow-black/50 select-none mb-6 flex-shrink-0">
                    <!-- Rings (No Text, just colors and borders) -->
                    <div class="absolute inset-0 bg-[#ffffff] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[5%] bg-[#ffffff] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[10%] bg-[#000000] border border-white/40 rounded-full"></div>
                    <div class="absolute inset-[15%] bg-[#000000] border border-white/40 rounded-full"></div>
                    <div class="absolute inset-[20%] bg-[#00b0f0] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[25%] bg-[#00b0f0] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[30%] bg-[#ff0000] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[35%] bg-[#ff0000] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[40%] bg-[#ffff00] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[45%] bg-[#ffff00] border border-slate-800 rounded-full"></div>
                    <div class="absolute inset-[48%] bg-[#ffff00] border border-slate-800/50 rounded-full"></div>

                    <!-- Precise Absolute Horizontal Numbers Overlay -->
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-4 w-full font-normal pointer-events-none">
                        <!-- Left Side Numbers -->
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 2.5%">1</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 7.5%">2</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px]" style="left: 12.5%; color: #ffffff !important;">3</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px]" style="left: 17.5%; color: #ffffff !important;">4</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 22.5%">5</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 27.5%">6</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 32.5%">7</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 37.5%">8</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 42.5%">9</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[5px] text-black" style="left: 46.5%">10</span>

                        <!-- Center X -->
                        <span class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 text-[5px] text-black font-semibold pb-px">x</span>

                        <!-- Right Side Numbers -->
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[5px] text-black" style="left: 53.5%">10</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 57.5%">9</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 62.5%">8</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 67.5%">7</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 72.5%">6</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 77.5%">5</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px]" style="left: 82.5%; color: #ffffff !important;">4</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px]" style="left: 87.5%; color: #ffffff !important;">3</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 92.5%">2</span>
                        <span class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-[6px] text-black" style="left: 97.5%">1</span>
                    </div>
                </div>

                <!-- Hit Data Grid -->
                <div class="w-full grid grid-cols-4 gap-2">
                    <?php 
                    $scoreList = ['X','10','9','8','7','6','5','4','3','2','1','M'];
                    foreach($scoreList as $lbl): 
                        $count = $getCount($lbl);
                        $bgClass = 'bg-slate-700'; 
                        $textStyle = 'color: #ffffff !important;';
                        if (in_array($lbl, ['X','10','9'])) { $bgClass = 'bg-[#ffff00]'; $textStyle = 'color: #000000 !important;'; }
                        if (in_array($lbl, ['8','7'])) { $bgClass = 'bg-[#ff0000]'; $textStyle = 'color: #ffffff !important;'; }
                        if (in_array($lbl, ['6','5'])) { $bgClass = 'bg-[#00b0f0]'; $textStyle = 'color: #000000 !important;'; }
                        if (in_array($lbl, ['4','3'])) { $bgClass = 'bg-[#000000] border border-slate-600'; $textStyle = 'color: #ffffff !important;'; }
                        if (in_array($lbl, ['2','1'])) { $bgClass = 'bg-[#ffffff] border border-slate-300'; $textStyle = 'color: #000000 !important;'; }
                        if ($lbl === 'M') { $bgClass = 'bg-slate-300 dark:bg-slate-700'; $textStyle = ''; } // Let M fallback to default styling
                    ?>
                        <div class="flex flex-col items-center p-1.5 rounded-xl bg-slate-800/40 border <?= $count > 0 ? 'border-brand-500/30 shadow-sm shadow-brand-500/10' : 'border-slate-700/30' ?>">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-black shadow-sm mb-1 <?= $bgClass ?>" style="<?= $textStyle ?>"><?= $lbl ?></div>
                            <span class="text-sm font-bold <?= $count > 0 ? 'text-white' : 'text-slate-500' ?>"><?= $count ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center h-48 text-slate-500 text-xs">
                <i class='bx bx-pie-chart-alt-2 text-3xl text-slate-600 mb-2'></i>
                <span>Belum ada tembakan tercatat</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Chart 3: Top 5 Atlet -->
    <div class="p-4 bg-slate-850 border border-slate-800/90 rounded-3xl select-none relative overflow-hidden">
        <div class="flex justify-between items-center mb-4 relative z-10">
            <div>
                <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Top 5 Atlet</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Rata-rata skor per game tertinggi</p>
            </div>
            <div class="w-8 h-8 rounded-full bg-sky-500/10 flex items-center justify-center text-sky-400 border border-sky-500/20">
                <i class='bx bx-bar-chart text-lg'></i>
            </div>
        </div>
        <div class="w-full relative h-48 z-10">
            <?php if (count(json_decode($topAthleteLabels)) > 0): ?>
                <canvas id="topAthleteChart"></canvas>
            <?php else: ?>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 text-xs">
                    <i class='bx bx-bar-chart-square text-3xl text-slate-600 mb-2'></i>
                    <span>Belum ada data atlet</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Existing Bulutangkis Chart -->
<div class="mb-6 p-4 bg-slate-850 border border-slate-800/90 rounded-3xl select-none">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Tren Skor Terkini</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Grafik nilai kemenangan match terbaru</p>
        </div>
        <span class="text-[10px] px-2.5 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full font-bold">BULUTANGKIS</span>
    </div>
    
    <div class="w-full relative h-40">
        <?php if ($totalGames > 0): ?>
            <canvas id="dashboardChart"></canvas>
        <?php else: ?>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 text-xs">
                <i class='bx bx-bar-chart-alt-2 text-3xl text-slate-600 mb-2'></i>
                <span>Belum ada data match</span>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Latest Games Activities -->
<div class="mb-4">
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Aktivitas Terbaru</h3>
        <a href="/sports" class="text-[10px] font-bold text-<?= $isPanahan ? 'brand' : 'emerald' ?>-400 hover:text-<?= $isPanahan ? 'brand' : 'emerald' ?>-300 transition-colors">Lihat Semua</a>
    </div>

    <div class="space-y-2.5">
        <?php if (empty($latestGames)): ?>
            <div class="bg-slate-800/20 border border-dashed border-slate-800 p-8 rounded-2xl text-center text-slate-500 text-xs">
                <i class='bx bx-folder text-2xl text-slate-600 mb-1 block'></i>
                Belum ada aktivitas game <?= esc(strtolower($activeCabor)) ?> terbaru
            </div>
        <?php else: ?>
            <?php foreach ($latestGames as $game): ?>
                <div class="bg-slate-800/30 border border-slate-800/80 p-3 rounded-2xl flex items-center justify-between hover:border-slate-700 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/10 border border-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/20 flex items-center justify-center text-<?= $isPanahan ? 'brand' : 'emerald' ?>-400 shrink-0 shadow shadow-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/5">
                            <i class='bx <?= $isPanahan ? 'bx-bullseye' : 'bx-tennis-ball' ?> text-xl'></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block"><?= esc($game['nama_anggota']) ?></span>
                            <span class="text-[9px] text-slate-500 font-medium block mt-0.5"><?= date('d M Y', strtotime($game['tanggal'])) ?> | <?= $isPanahan ? $game['jumlah_sesi'].' Sesi' : $game['tipe_match'] ?></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <span class="text-xs font-semibold text-slate-400 block uppercase text-[9px] tracking-wider"><?= $isPanahan ? 'Score' : 'Menang' ?></span>
                            <span class="text-sm font-bold text-<?= $isPanahan ? 'emerald' : 'sky' ?>-400 block"><?= $isPanahan ? $game['total_score'] : $game['set_menang_atlet'] . ' Set' ?></span>
                        </div>
                        <a href="/<?= strtolower($activeCabor) ?>/<?= $isPanahan ? 'game' : 'riwayat' ?>/<?= $isPanahan ? $game['id'] : $game['anggota_id'] ?>" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-750 flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class='bx bx-chevron-right text-lg'></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Load Chart.js CDN is now in main.php -->
<?php if ($totalGames > 0 || $totalShots > 0): ?>
<script>
    (function() {
        const isLightMode = document.documentElement.classList.contains('light-mode');
        const textColor = '#64748b';
        const gridColor = isLightMode ? '#e5e7eb' : 'rgba(255, 255, 255, 0.05)';
        const tooltipBg = isLightMode ? '#ffffff' : '#1e293b';
        const tooltipTitle = isLightMode ? '#0f172a' : '#f8fafc';
        const tooltipBody = isLightMode ? '#334155' : '#cbd5e1';
        const tooltipBorder = isLightMode ? '#e5e7eb' : '#334155';

        // 1. Line Chart: Tren Skor Terkini
        <?php if ($totalGames > 0): ?>
        const ctxLine = document.getElementById('dashboardChart');
        if (ctxLine) {
            let existingChart = Chart.getChart(ctxLine);
            if (existingChart) existingChart.destroy();
            
            new Chart(ctxLine.getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?= $chartLabels ?>,
                    datasets: [{
                        label: 'Skor Total',
                        data: <?= $chartScores ?>,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 1.5,
                        pointRadius: 4.5,
                        pointHoverRadius: 6,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: tooltipBg, titleColor: tooltipTitle, bodyColor: tooltipBody,
                            borderColor: tooltipBorder, borderWidth: 1, padding: 8, cornerRadius: 8,
                            titleFont: { family: 'Outfit', size: 10, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 11 }
                        }
                    },
                    scales: {
                        y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Outfit', size: 8.5 } } },
                        x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Outfit', size: 8 } } }
                    }
                }
            });
        }
        <?php endif; ?>

        <?php if ($isPanahan): ?>
        // 3. Bar Chart: Top 5 Atlet
        <?php if (count(json_decode($topAthleteLabels)) > 0): ?>
        const ctxBar = document.getElementById('topAthleteChart');
        if (ctxBar) {
            let existingBar = Chart.getChart(ctxBar);
            if (existingBar) existingBar.destroy();

            new Chart(ctxBar.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?= $topAthleteLabels ?>,
                    datasets: [{
                        label: 'Rata-rata Skor',
                        data: <?= $topAthleteData ?>,
                        backgroundColor: '#0ea5e9',
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: tooltipBg, titleColor: tooltipTitle, bodyColor: tooltipBody,
                            borderColor: tooltipBorder, borderWidth: 1, padding: 8, cornerRadius: 8,
                            titleFont: { family: 'Outfit', size: 10, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 11 }
                        }
                    },
                    scales: {
                        y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Outfit', size: 8.5 } } },
                        x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Outfit', size: 10, weight: 'bold' } } }
                    }
                }
            });
        }
        <?php endif; ?>
        <?php endif; ?>
    })();
</script>
<?php endif; ?>

<?= $this->endSection() ?>
