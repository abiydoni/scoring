<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="h-full flex flex-col pt-4">
    <!-- Scoreboard Header -->
    <div class="px-4 mb-4 flex items-center justify-between">
        <a href="/bulutangkis/riwayat/<?= $match['anggota_id'] ?>" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
            <i class='bx bx-arrow-back text-xl'></i>
        </a>
        <div class="text-center">
            <span class="text-[10px] font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-full uppercase tracking-widest block mb-1 shadow-sm">
                <?= esc($match['tipe_match']) ?> • Set <?= $currentGame ? $currentGame['set_ke'] : (count($allGames)) ?>
            </span>
            <div class="flex items-center justify-center gap-2 text-sm font-bold text-white mt-1">
                <span><?= $match['set_menang_atlet'] ?></span>
                <span class="text-slate-500">SETS</span>
                <span><?= $match['set_menang_lawan'] ?></span>
            </div>
        </div>
        <div class="w-10 h-10"></div> <!-- Spacer for centering -->
    </div>

    <!-- Set History Dots -->
    <div class="flex justify-center gap-2 mb-6 px-4">
        <?php foreach($allGames as $g): ?>
            <div class="text-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold <?= $g['is_finished'] ? ($g['poin_atlet'] > $g['poin_lawan'] ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30') : 'bg-slate-800 text-slate-400' ?>">
                    S<?= $g['set_ke'] ?>
                </div>
                <?php if($g['is_finished']): ?>
                    <span class="text-[9px] text-slate-500 block mt-1"><?= $g['poin_atlet'] ?>-<?= $g['poin_lawan'] ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($match['status'] === 'finished'): ?>
        <div class="flex-1 flex flex-col items-center justify-center px-4">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/30 mb-6">
                <i class='bx bx-trophy text-5xl text-white'></i>
            </div>
            <h2 class="text-3xl font-black text-white mb-2">Pertandingan Selesai!</h2>
            <?php 
                $timKita = esc($atlet['nama']);
                if ($match['tipe_match'] === 'Ganda' && !empty($partner)) {
                    $timKita .= ' & ' . esc($partner['nama']);
                }
                
                $timLawan = $match['lawan_nama'] ? esc($match['lawan_nama']) : 'Lawan Anonim';
                if ($match['tipe_match'] === 'Ganda' && !empty($match['lawan_partner_nama'])) {
                    $timLawan .= ' & ' . esc($match['lawan_partner_nama']);
                }
            ?>
            <p class="text-slate-400 mb-8 text-center">Skor Akhir: <?= $timKita ?> (<?= $match['set_menang_atlet'] ?>) vs (<?= $match['set_menang_lawan'] ?>) <?= $timLawan ?></p>
            <a href="/bulutangkis/riwayat/<?= $match['anggota_id'] ?>" class="px-8 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-full font-bold transition-all shadow-md">
                Kembali ke Riwayat
            </a>
        </div>
    <?php else: ?>
        <!-- Interactive Scoreboard Area -->
        <div class="flex-1 flex px-4 gap-3 pb-8">
            <!-- Player A (Atlet) -->
            <div class="flex-1 flex flex-col">
                <div class="bg-slate-900 border border-slate-800 rounded-t-3xl py-3 px-2 text-center shadow-inner">
                    <?php 
                        $timKita = esc($atlet['nama']);
                        if ($match['tipe_match'] === 'Ganda' && !empty($partner)) {
                            $timKita .= ' & ' . esc($partner['nama']);
                        }
                    ?>
                    <h3 class="text-sm font-bold text-white truncate px-1" title="<?= $timKita ?>"><?= $timKita ?></h3>
                    <span class="text-[10px] text-emerald-400 font-semibold uppercase">Tim Kita</span>
                </div>
                
                <!-- Big Touch Area -->
                <button onclick="updateScore('atlet', 'plus')" class="flex-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-b-3xl shadow-lg shadow-emerald-900/40 flex items-center justify-center relative overflow-hidden group active:scale-[0.98] transition-all">
                    <div class="absolute inset-0 bg-white/0 group-active:bg-white/10 transition-colors"></div>
                    <span id="score_atlet" class="text-8xl font-black text-white drop-shadow-lg select-none"><?= $currentGame['poin_atlet'] ?></span>
                    <i class='bx bx-plus absolute top-4 right-4 text-emerald-300/50 text-3xl group-active:scale-150 transition-transform'></i>
                </button>
                
                <!-- Minus Button -->
                <button onclick="updateScore('atlet', 'minus')" class="mt-3 w-full py-3 bg-slate-800/80 hover:bg-slate-700 border border-slate-700 rounded-2xl text-slate-400 flex items-center justify-center gap-1 active:scale-95 transition-all">
                    <i class='bx bx-minus text-lg'></i> Kurangi
                </button>
            </div>

            <div class="w-px bg-slate-800 my-4 flex flex-col items-center justify-center">
                <span class="bg-slate-950 px-1 py-2 text-slate-600 text-[10px] font-black uppercase">VS</span>
            </div>

            <!-- Player B (Lawan) -->
            <div class="flex-1 flex flex-col">
                <div class="bg-slate-900 border border-slate-800 rounded-t-3xl py-3 px-2 text-center shadow-inner">
                    <?php 
                        $timLawan = $match['lawan_nama'] ? esc($match['lawan_nama']) : 'Lawan Anonim';
                        if ($match['tipe_match'] === 'Ganda' && !empty($match['lawan_partner_nama'])) {
                            $timLawan .= ' & ' . esc($match['lawan_partner_nama']);
                        }
                    ?>
                    <h3 class="text-sm font-bold text-white truncate px-1" title="<?= $timLawan ?>">
                        <?= $timLawan ?>
                    </h3>
                    <span class="text-[10px] text-rose-400 font-semibold uppercase">Lawan</span>
                </div>
                
                <!-- Big Touch Area -->
                <button onclick="updateScore('lawan', 'plus')" class="flex-1 bg-gradient-to-br from-rose-600 to-red-800 rounded-b-3xl shadow-lg shadow-rose-900/40 flex items-center justify-center relative overflow-hidden group active:scale-[0.98] transition-all">
                    <div class="absolute inset-0 bg-white/0 group-active:bg-white/10 transition-colors"></div>
                    <span id="score_lawan" class="text-8xl font-black text-white drop-shadow-lg select-none"><?= $currentGame['poin_lawan'] ?></span>
                    <i class='bx bx-plus absolute top-4 right-4 text-rose-300/50 text-3xl group-active:scale-150 transition-transform'></i>
                </button>
                
                <!-- Minus Button -->
                <button onclick="updateScore('lawan', 'minus')" class="mt-3 w-full py-3 bg-slate-800/80 hover:bg-slate-700 border border-slate-700 rounded-2xl text-slate-400 flex items-center justify-center gap-1 active:scale-95 transition-all">
                    <i class='bx bx-minus text-lg'></i> Kurangi
                </button>
            </div>
        </div>

        <!-- Finish Set Button -->
        <div class="px-4 pb-6">
            <button onclick="confirmFinishSet()" class="w-full py-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-2xl shadow-lg shadow-brand-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <i class='bx bx-flag text-xl'></i>
                Selesai Set <?= $currentGame['set_ke'] ?>
            </button>
        </div>

        <!-- Audio element for scoring ping -->
        <!-- Note: Real app might use an actual sound file. Here we just setup the function -->
        
        <script>
            var gameId = <?= $currentGame['id'] ?>;
            
            function updateScore(player, action) {
                const elA = document.getElementById('score_atlet');
                const elB = document.getElementById('score_lawan');
                let scoreA = parseInt(elA.innerText);
                let scoreB = parseInt(elB.innerText);
                
                let el = player === 'atlet' ? elA : elB;
                let currentScore = player === 'atlet' ? scoreA : scoreB;
                
                if (action === 'plus') {
                    if ((scoreA >= 21 && scoreA - scoreB >= 2) || 
                        (scoreB >= 21 && scoreB - scoreA >= 2) || 
                        scoreA >= 30 || scoreB >= 30) {
                        Swal.fire('Set Selesai', 'Poin tidak dapat ditambah karena batas kemenangan set (maks 30) telah tercapai. Silakan selesaikan set.', 'warning');
                        return;
                    }
                    currentScore++;
                    // Add pop animation class
                    el.classList.remove('animate-[pop_0.2s_ease-out]');
                    void el.offsetWidth; // trigger reflow
                    el.classList.add('animate-[pop_0.2s_ease-out]');
                } else if (action === 'minus' && currentScore > 0) {
                    currentScore--;
                } else {
                    return; // Can't go below 0
                }
                
                el.innerText = currentScore;

                // Send request
                fetch('/bulutangkis/update_score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        'game_id': gameId,
                        'player': player,
                        'action': action
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Sync just in case
                        document.getElementById('score_atlet').innerText = data.poin_atlet;
                        document.getElementById('score_lawan').innerText = data.poin_lawan;
                        
                        // Check for auto finish warning (e.g. 21 points)
                        checkSetPoints(data.poin_atlet, data.poin_lawan);
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                });
            }

            function checkSetPoints(scoreA, scoreB) {
                // Bulutangkis rule: 21 points, win by 2
                if ((scoreA >= 21 || scoreB >= 21) && Math.abs(scoreA - scoreB) >= 2) {
                    // Show subtle toast or highlight finish button
                    const btn = document.querySelector('button[onclick="confirmFinishSet()"]');
                    btn.classList.remove('bg-brand-600');
                    btn.classList.add('bg-amber-500', 'animate-pulse');
                    btn.innerHTML = "<i class='bx bx-bell text-xl'></i> Selesaikan Set " + <?= $currentGame['set_ke'] ?> + " Sekarang";
                } else if (scoreA === 30 || scoreB === 30) {
                    // Max points reached
                     const btn = document.querySelector('button[onclick="confirmFinishSet()"]');
                    btn.classList.remove('bg-brand-600');
                    btn.classList.add('bg-amber-500', 'animate-pulse');
                }
            }

            function confirmFinishSet() {
                const scoreA = parseInt(document.getElementById('score_atlet').innerText);
                const scoreB = parseInt(document.getElementById('score_lawan').innerText);
                
                if (scoreA === scoreB) {
                    Swal.fire('Peringatan', 'Skor saat ini seimbang (Seri). Set tidak dapat diselesaikan!', 'warning');
                    return;
                }

                let winner = scoreA > scoreB ? '<?= $timKita ?>' : '<?= $timLawan ?>';

                Swal.fire({
                    title: 'Selesaikan Set?',
                    html: `Set akan dimenangkan oleh <b>${winner}</b> dengan skor ${scoreA} - ${scoreB}.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Selesai',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        finishSet();
                    }
                })
            }

            function finishSet() {
                showLoading('MENYIMPAN SET', 'Memproses hasil pertandingan...');

                fetch('/bulutangkis/finish_game', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        'game_id': gameId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        hideLoading();
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(() => {
                    hideLoading();
                    Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
                });
            }
        </script>
        
        <style>
            @keyframes pop {
                0% { transform: scale(1); }
                50% { transform: scale(1.15); }
                100% { transform: scale(1); }
            }
        </style>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
