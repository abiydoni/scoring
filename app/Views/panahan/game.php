<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Game Details Card -->
<div class="mb-6 bg-gradient-to-br from-slate-800/60 to-slate-900/60 border border-slate-800 p-5 rounded-3xl relative overflow-hidden select-none shadow shadow-black/20">
    <div class="absolute -right-12 -top-12 w-28 h-28 bg-brand-500/10 rounded-full blur-xl"></div>
    
    <?php if ($game['tipe_game'] === 'aduan'): ?>
        <!-- VS Scoreboard Duel Style -->
        <div class="relative z-10">
            <div class="flex justify-between items-center mb-4 border-b border-slate-800/60 pb-3">
                <div>
                    <span class="text-[9px] font-bold text-amber-400 uppercase tracking-widest px-2 py-0.5 bg-amber-500/10 rounded border border-amber-500/25">
                        Match Play - <?= $game['divisi'] === 'compound' ? 'Compound' : 'Recurve/Nasional' ?>
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 font-medium"><?= date('d M Y', strtotime($game['tanggal'])) ?></span>
                </div>
            </div>

            <!-- Side-by-Side Competitors -->
            <div class="flex items-center justify-between gap-1 mt-2.5">
                <!-- Main Athlete -->
                <div class="flex-1 text-center max-w-[120px]">
                    <div class="w-10 h-10 rounded-full bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 font-black text-sm mx-auto shadow shadow-brand-500/5">
                        <?= strtoupper(substr($game['nama_anggota'], 0, 2)) ?>
                    </div>
                    <span class="text-xs font-bold text-white block mt-1.5 truncate"><?= esc(explode(' ', $game['nama_anggota'])[0]) ?></span>
                    <span class="text-[9px] text-slate-500 mt-0.5 block truncate">
                        <?= $game['divisi'] === 'compound' ? 'Compound' : 'Skor: ' . $game['total_score'] ?>
                    </span>
                </div>

                <!-- Score / Points display (Center) -->
                <div class="text-center shrink-0">
                    <div class="flex items-center justify-center gap-3">
                        <?php if ($game['divisi'] === 'compound'): ?>
                            <span class="text-3xl font-black text-emerald-400"><?= $game['total_score'] ?></span>
                            <span class="text-xs font-extrabold text-slate-600 uppercase tracking-widest">VS</span>
                            <span class="text-3xl font-black text-emerald-400"><?= $game['total_score_lawan'] ?></span>
                        <?php else: ?>
                            <span class="text-3xl font-black text-white"><?= $game['set_point_atlet'] ?></span>
                            <span class="text-xs font-extrabold text-slate-600 uppercase tracking-widest">VS</span>
                            <span class="text-3xl font-black text-white"><?= $game['set_point_lawan'] ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest block mt-1 bg-slate-800/40 px-2 py-0.5 rounded-full border border-slate-800">
                        <?= $game['divisi'] === 'compound' ? 'Total Skor' : 'Set Points' ?>
                    </span>
                </div>

                <!-- Opponent -->
                <div class="flex-1 text-center max-w-[120px]">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 font-black text-sm mx-auto shadow shadow-amber-500/5">
                        <?= strtoupper(substr($namaLawan, 0, 2)) ?>
                    </div>
                    <span class="text-xs font-bold text-white block mt-1.5 truncate"><?= esc(explode(' ', $namaLawan)[0]) ?></span>
                    <span class="text-[9px] text-slate-500 mt-0.5 block truncate">
                        <?= $game['divisi'] === 'compound' ? 'Compound' : 'Skor: ' . $game['total_score_lawan'] ?>
                    </span>
                </div>
            </div>

            <!-- Match status winner badges -->
            <?php 
                if ($game['divisi'] === 'compound') {
                    // Check if both sides have shot all 15 arrows (5 sets * 2 shoot records = 10 records)
                    $db = \Config\Database::connect();
                    $completedSetsCount = $db->table('panahan_shoot')
                                             ->where('game_id', $game['id'])
                                             ->where('session_number', 1)
                                             ->countAllResults();
                    $isFinished = ($completedSetsCount >= 10);
                    
                    $atletWon = ($isFinished && $game['total_score'] > $game['total_score_lawan']);
                    $lawanWon = ($isFinished && $game['total_score_lawan'] > $game['total_score']);
                    $isTie = ($isFinished && $game['total_score'] === $game['total_score_lawan']);
                } else {
                    $atletWon = ($game['set_point_atlet'] >= 6 && $game['set_point_atlet'] > $game['set_point_lawan']);
                    $lawanWon = ($game['set_point_lawan'] >= 6 && $game['set_point_lawan'] > $game['set_point_atlet']);
                    $isTie = false;
                }
            ?>
            <?php if ($atletWon || $lawanWon): ?>
                <div class="mt-4 pt-3 border-t border-slate-800/40 text-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 px-3 py-1 bg-emerald-500/10 rounded-full border border-emerald-500/25 inline-flex items-center gap-1">
                        <i class='bx bxs-crown text-xs'></i>
                        <span>Winner: <?= esc($atletWon ? explode(' ', $game['nama_anggota'])[0] : explode(' ', $namaLawan)[0]) ?></span>
                    </span>
                </div>
            <?php elseif ($isTie): ?>
                <div class="mt-4 pt-3 border-t border-slate-800/40 text-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-400 px-3 py-1 bg-amber-500/10 rounded-full border border-amber-500/25 inline-flex items-center gap-1">
                        <i class='bx bx-git-commit text-xs'></i>
                        <span>Match Seri (Shoot-Off)</span>
                    </span>
                </div>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <!-- Standard Qualification Details -->
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <span class="text-[9px] font-bold text-brand-400 uppercase tracking-widest">Detail Latihan Panahan</span>
                <h3 class="text-base font-extrabold text-white mt-1 leading-tight"><?= esc($game['nama_anggota']) ?></h3>
                
                <div class="space-y-1.5 mt-3">
                    <span class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                        <i class='bx bx-calendar text-brand-400 text-xs shrink-0'></i>
                        <span>Tanggal: <?= date('d M Y', strtotime($game['tanggal'])) ?></span>
                    </span>
                    
                    <?php if ($game['keterangan']): ?>
                        <span class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                            <i class='bx bx-info-circle text-brand-400 text-xs shrink-0'></i>
                            <span class="truncate max-w-[200px]" title="<?= esc($game['keterangan']) ?>"><?= esc($game['keterangan']) ?></span>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="text-right">
                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-widest block">Grand Total</span>
                <span class="text-2xl font-black text-emerald-400 mt-1 block leading-none"><?= $game['total_score'] ?></span>
                <span class="text-[8px] font-bold text-emerald-500/80 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/15 block mt-2 inline-block">Points</span>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Sessions List Grid -->
<div class="space-y-3">
    <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-1 select-none">
        <?= $game['tipe_game'] === 'aduan' ? 'Sesi Tanding (Sets)' : 'Lembar Scoring Sesi' ?>
    </h3>
    
    <?php 
        // Pre-build a map for session totals for quick display
        $totalsMap = [];
        foreach ($sessionTotals as $st) {
            $totalsMap[$st['session_number']] = $st['total_score'];
        }
    ?>

    <?php for ($i = 1; $i <= $jumlahSesi; $i++): ?>
        <?php 
            $sessionScore = $totalsMap[$i] ?? 0;
            $hasScore = isset($totalsMap[$i]) || ($game['tipe_game'] === 'aduan');
        ?>
        <div class="bg-slate-800/30 border border-slate-800/80 p-4 rounded-3xl hover:border-slate-700 transition-all flex justify-between items-center group">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-slate-800/80 border border-slate-750 flex items-center justify-center text-slate-400 shrink-0">
                    <i class='bx bx-spreadsheet text-xl'></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-white block"><?= $game['tipe_game'] === 'aduan' ? 'Pertandingan Set' : 'Sesi ' . $i ?></span>
                    <span class="text-[9px] text-slate-500 font-semibold uppercase block mt-0.5">
                        <?= $game['tipe_game'] === 'aduan' ? ($game['divisi'] === 'compound' ? '5 Set Duel (15 Anak Panah Akumulatif)' : 'Maksimal 5 Set Duel (3 Anak Panah per Set)') : '36 Anak Panah (6 Rambahan)' ?>
                    </span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <?php if ($game['tipe_game'] !== 'aduan'): ?>
                    <div class="text-right select-none">
                        <span class="text-[8px] font-bold text-slate-500 uppercase tracking-wide">Total Sesi</span>
                        <span class="text-xs font-bold text-indigo-400 block mt-0.5"><?= $sessionScore ?> pts</span>
                    </div>
                <?php endif; ?>
                
                <a href="/panahan/game/<?= $game['id'] ?>/sesi/<?= $i ?>" class="px-3.5 py-2 <?= $hasScore && $game['tipe_game'] !== 'aduan' ? 'bg-brand-600/10 text-brand-400 border border-brand-500/15 hover:bg-brand-600 hover:text-white hover:border-brand-500' : 'bg-brand-600 text-white shadow-md shadow-brand-500/10' ?> rounded-2xl transition-all text-xs font-bold flex items-center gap-1 active:scale-95 duration-200">
                    <span><?= $game['tipe_game'] === 'aduan' ? 'Masuk Scoring' : ($hasScore ? 'Lihat/Edit' : 'Input Skor') ?></span>
                    <i class='bx bx-edit text-xs shrink-0'></i>
                </a>
            </div>
        </div>
    <?php endfor; ?>
</div>

<?= $this->endSection() ?>
