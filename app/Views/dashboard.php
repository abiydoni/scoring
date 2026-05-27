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
<div class="grid grid-cols-2 gap-3.5 mb-6">
    <!-- Stat Item: Active Athletes -->
    <div class="bg-slate-800/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition-all select-none">
        <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-<?= $isPanahan ? 'brand' : 'emerald' ?>-400 shrink-0 mb-3 shadow shadow-black/20">
            <i class='bx bx-group text-lg'></i>
        </div>
        <div>
            <span class="text-[10px] font-semibold text-slate-400 tracking-wide block uppercase">Total Atlet</span>
            <span class="text-xl font-bold text-white mt-1 block"><?= $totalAthletes ?> <span class="text-xs text-slate-500 font-normal">orang</span></span>
        </div>
    </div>

    <!-- Stat Item: Total Sesi Game -->
    <div class="bg-slate-800/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition-all select-none">
        <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400 shrink-0 mb-3 shadow shadow-black/20">
            <i class='bx bx-trophy text-lg'></i>
        </div>
        <div>
            <span class="text-[10px] font-semibold text-slate-400 tracking-wide block uppercase"><?= $isPanahan ? 'Total Game' : 'Total Match' ?></span>
            <span class="text-xl font-bold text-white mt-1 block"><?= $totalGames ?> <span class="text-xs text-slate-500 font-normal"><?= $isPanahan ? 'sesi' : 'pertandingan' ?></span></span>
        </div>
    </div>

    <!-- Stat Item: Total Shots -->
    <div class="bg-slate-800/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition-all select-none">
        <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-amber-400 shrink-0 mb-3 shadow shadow-black/20">
            <i class='bx <?= $isPanahan ? 'bx-target-lock' : 'bx-tennis-ball' ?> text-lg'></i>
        </div>
        <div>
            <span class="text-[10px] font-semibold text-slate-400 tracking-wide block uppercase"><?= $isPanahan ? 'Anak Panah' : 'Total Set' ?></span>
            <span class="text-xl font-bold text-white mt-1 block"><?= $totalShots ?> <span class="text-xs text-slate-500 font-normal"><?= $isPanahan ? 'terlepas' : 'set' ?></span></span>
        </div>
    </div>

    <!-- Stat Item: Highest Score -->
    <div class="bg-slate-800/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition-all select-none">
        <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-<?= $isPanahan ? 'emerald' : 'sky' ?>-400 shrink-0 mb-3 shadow shadow-black/20">
            <i class='bx bx-star text-lg'></i>
        </div>
        <div>
            <span class="text-[10px] font-semibold text-slate-400 tracking-wide block uppercase"><?= $isPanahan ? 'Skor Tertinggi' : 'Set Menang Max' ?></span>
            <span class="text-xl font-bold text-white mt-1 block" title="Rekor oleh: <?= esc($highestAthlete) ?>"><?= $highestScore ?></span>
            <span class="text-[9px] text-<?= $isPanahan ? 'emerald' : 'sky' ?>-400 font-medium truncate block mt-0.5" title="<?= esc($highestAthlete) ?>"><?= esc($highestAthlete) ?></span>
        </div>
    </div>
</div>

<!-- Performance Chart -->
<div class="mb-6 p-4 bg-slate-850 border border-slate-800/90 rounded-3xl select-none">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Tren Skor Terkini</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Grafik nilai total <?= $isPanahan ? 'game' : 'match' ?> terbaru</p>
        </div>
        <span class="text-[10px] px-2.5 py-1 bg-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/10 text-<?= $isPanahan ? 'brand' : 'emerald' ?>-400 border border-<?= $isPanahan ? 'brand' : 'emerald' ?>-500/20 rounded-full font-bold"><?= esc($activeCabor) ?></span>
    </div>
    
    <div class="w-full relative h-40">
        <?php if ($totalGames > 0): ?>
            <canvas id="dashboardChart"></canvas>
        <?php else: ?>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 text-xs">
                <i class='bx bx-bar-chart-alt-2 text-3xl text-slate-600 mb-2'></i>
                <span>Belum ada data game untuk ditampilkan</span>
            </div>
        <?php endif; ?>
    </div>
</div>

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

<!-- Load Chart.js CDN -->
<?php if ($totalGames > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        
        const labels = <?= $chartLabels ?>;
        const scores = <?= $chartScores ?>;
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Total',
                    data: scores,
                    borderColor: (document.body.classList.contains('light-mode') ? '#8b5cf6' : '#8b5cf6'), // keep brand color
                    backgroundColor: (document.body.classList.contains('light-mode') ? 'rgba(139, 92, 246, 0.1)' : 'rgba(139, 92, 246, 0.1)'),
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: (document.body.classList.contains('light-mode') ? '#ffffff' : '#1e293b'),
                        titleColor: (document.body.classList.contains('light-mode') ? '#0f172a' : '#f8fafc'),
                        bodyColor: (document.body.classList.contains('light-mode') ? '#334155' : '#cbd5e1'),
                        borderWidth: 1,
                        borderColor: (document.body.classList.contains('light-mode') ? '#e5e7eb' : '#334155'),
                        padding: 8,
                        boxPadding: 4,
                        cornerRadius: 8,
                        titleFont: {
                            family: 'Outfit',
                            size: 10,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Outfit',
                            size: 11
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: (document.body.classList.contains('light-mode') ? '#e5e7eb' : 'rgba(255, 255, 255, 0.05)')
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'Outfit',
                                size: 8.5
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'Outfit',
                                size: 8
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
<?php endif; ?>

<?= $this->endSection() ?>
