<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Athlete Info card -->
<div class="mb-5 bg-slate-800/20 border border-slate-800 p-4 rounded-3xl flex items-center justify-between select-none">
    <div class="flex items-center gap-3">
        <?php if (!empty($anggota['foto'])): ?>
            <img src="/uploads/anggota/<?= esc($anggota['foto']) ?>" onclick="showImageModal('/uploads/anggota/<?= esc($anggota['foto']) ?>')" class="w-12 h-12 rounded-2xl object-cover border border-brand-500/20 shadow-sm shrink-0 cursor-pointer hover:scale-105 transition-transform">
        <?php else: ?>
            <div class="w-12 h-12 rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 font-extrabold text-lg shrink-0 shadow shadow-brand-500/5">
                <?= strtoupper(substr($anggota['nama'], 0, 2)) ?>
            </div>
        <?php endif; ?>
        <div>
            <h3 class="text-sm font-bold text-white"><?= esc($anggota['nama']) ?></h3>
            <span class="text-[9px] text-slate-500 font-semibold uppercase block tracking-wider mt-0.5">Daftar Game Panahan</span>
<?php if (!empty($anggota['divisi'])): ?>
    <span class="text-[9px] px-1.5 py-0.5 bg-brand-500/10 text-brand-400 border border-brand-500/20 rounded font-black tracking-wide uppercase inline-block mt-1"><?= esc($anggota['divisi']) ?></span>
<?php endif; ?>
<?php if (!empty($anggota['klub'])): ?>
    <span class="text-[9px] text-slate-400 font-medium ml-1 flex items-center inline-flex gap-1 mt-1"><i class='bx bx-building-house'></i> <?= esc($anggota['klub']) ?></span>
<?php endif; ?>
<?php if (!empty($anggota['kota'])): ?>
    <span class="text-[9px] text-slate-400 font-medium ml-1 flex items-center inline-flex gap-1 mt-1"><i class='bx bx-map'></i> <?= esc($anggota['kota']) ?></span>
<?php endif; ?>
        </div>
    </div>
    
    <button onclick="showNewGameForm()" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-2xl transition-all text-xs font-bold flex items-center gap-1 active:scale-95 duration-200 shadow-md shadow-brand-500/15">
        <i class='bx bx-plus text-base'></i>
        <span>Game Baru</span>
    </button>
</div>

<!-- New Game Drawer Panel (Hidden by default) -->
<div id="new-game-panel" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm"><div class="bg-slate-800/90 light-modal p-6 rounded-3xl max-w-md w-full mx-4">
    <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-4">Buat Permainan Baru</h3>
    
    <form onsubmit="createNewGame(event)">
        <input type="hidden" id="anggota_id" name="anggota_id" value="<?= $anggota['id'] ?>">
        
        <div class="space-y-4">
            <!-- 1. Tanggal Latihan -->
            <div>
                <label for="tanggal" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal Latihan <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-calendar text-base'></i>
                    </div>
                    <input type="date" id="tanggal" name="tanggal" required class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none">
                </div>
            </div>

            <!-- 2. Tipe Game -->
            <div>
                <label for="tipe_game" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tipe Permainan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-target-lock text-base'></i>
                        </div>
                        <select id="tipe_game" name="tipe_game" onchange="toggleGameType(this.value)" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="kualifikasi">Kualifikasi (Scoring)</option>
                            <option value="aduan">Aduan (Match Play)</option>
                            <option value="mixteam">Mix Team (Beregu Campuran)</option>
                        </select>
                    </div>
            </div>

            <!-- Divisi / Kategori (Only for Aduan) -->
            <div id="divisi-group" class="hidden">
                <label for="divisi" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Divisi / Kategori <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-purchase-tag-alt text-base'></i>
                    </div>
                    <select id="divisi" name="divisi" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                        <option value="recurve" selected>Recurve / Nasional (Sistem Set)</option>
                        <option value="compound">Compound (Sistem Akumulasi Skor)</option>
                    </select>
                </div>
            </div>

            <!-- 3. Jumlah Sesi (Only for Kualifikasi) -->
            <div id="jumlah-sesi-group">
                <label for="jumlah_sesi" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jumlah Sesi Latihan <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-list-check text-base'></i>
                    </div>
                    <input type="number" id="jumlah_sesi" name="jumlah_sesi" min="1" max="10" value="2" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none">
                </div>
                <p class="text-[9px] text-slate-500 mt-1.5 font-medium leading-relaxed">Masukkan total sesi scoring yang ingin dicatat (Umumnya 2 sesi).</p>
            </div>

            <!-- 4. Opponent Settings (Only for Aduan) -->
            <div id="opponent-group" class="hidden space-y-3.5">
                <!-- Select Opponent Mode -->
                <div>
                    <label for="lawan_select_type" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Cara Input Lawan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                            <input type="radio" name="lawan_select_type" value="database" checked onchange="toggleLawanInputMode(this.value)" class="text-brand-500 focus:ring-brand-500 bg-slate-900 border-slate-800">
                            <span>Dari Atlet Terdaftar</span>
                        </label>
                        <label class="flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                            <input type="radio" name="lawan_select_type" value="manual" onchange="toggleLawanInputMode(this.value)" class="text-brand-500 focus:ring-brand-500 bg-slate-900 border-slate-800">
                            <span>Input Manual</span>
                        </label>
                    </div>
                </div>

                <!-- Opponent Dropdown (From DB) -->
                <div id="opponent-db-input">
                    <label for="lawan_id" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Lawan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user-voice text-base'></i>
                        </div>
                        <select id="lawan_id" name="lawan_id" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="">-- Pilih Lawan --</option>
                        </select>
                    </div>
                </div>

                <!-- Opponent Name (Manual Text Field) -->
                <div id="opponent-manual-input" class="hidden">
                    <label for="lawan_nama" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5" id="label_lawan_nama">Nama Lawan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user text-base'></i>
                        </div>
                        <input type="text" id="lawan_nama" name="lawan_nama" placeholder="Masukkan nama lawan" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none">
                    </div>
                </div>
            </div>

            <!-- Partner Settings (Only for Mix Team) -->
            <div id="partner-group" class="hidden space-y-3.5">
                <label for="partner_id" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Pasangan (Partner) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-group text-base'></i>
                    </div>
                    <select id="partner_id" name="partner_id" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                        <option value="">-- Pilih Partner --</option>
                    </select>
                </div>
                <p class="text-[9px] text-slate-500 font-medium">Hanya menampilkan atlet dengan jenis kelamin berbeda di divisi yang sama.</p>
            </div>

            <!-- 5. Keterangan / Notes -->
            <div>
                <label for="keterangan" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Keterangan / Kategori Latihan</label>
                <div class="relative">
                    <textarea id="keterangan" name="keterangan" rows="2" placeholder="Contoh: Jarak 70 meter duel (opsional)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none resize-none"></textarea>
                </div>
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-2xl font-bold text-xs transition-all shadow-md shadow-brand-600/10 active:scale-95 duration-200">
                    <i class='bx bx-save mr-1.5'></i>
                    <span>Mulai Game</span>
                </button>
                <button type="button" onclick="hideNewGameForm()" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 rounded-2xl font-bold text-xs transition-all active:scale-95 duration-200">
                    Batal
                </button>
            </div>
        </div>
    </form>
</div></div>

<!-- History List -->
<div class="space-y-3">
    <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-1 select-none">Daftar Latihan Terbaru</h3>
    
    <?php if (empty($games)): ?>
        <div class="bg-slate-800/20 border border-dashed border-slate-800 py-12 px-4 rounded-3xl text-center text-slate-500 text-xs select-none">
            <i class='bx bx-target-lock text-4xl text-slate-750 mb-2 block'></i>
            <span>Belum ada permainan scoring panahan.<br>Klik tombol "Game Baru" untuk memulai.</span>
        </div>
    <?php else: ?>
        <?php foreach ($games as $game): ?>
            <div class="bg-slate-800/30 border border-slate-800/80 p-4 rounded-3xl hover:border-slate-700 transition-all flex justify-between items-center relative overflow-hidden group">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0 shadow shadow-brand-500/5">
                        <i class='bx bx-bullseye text-xl'></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-white block"><?= date('d F Y', strtotime($game['tanggal'])) ?></span>
                        <div class="flex items-center gap-2 mt-1">
                            <?php if ($game['tipe_game'] === 'aduan'): ?>
                                <span class="text-[9px] px-1.5 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded font-black tracking-wide uppercase">Aduan (<?= esc(ucfirst($game['divisi'] ?? 'recurve')) ?>)</span>
                                <span class="text-[9px] text-slate-500 font-bold">•</span>
                                <span class="text-[9px] text-slate-400 font-bold">vs <?= esc($game['lawan_id'] ? $game['nama_lawan_db'] : ($game['lawan_nama'] ?: 'Lawan')) ?></span>
                            <?php elseif ($game['tipe_game'] === 'mixteam'): ?>
                                <span class="text-[9px] px-1.5 py-0.5 bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded font-black tracking-wide uppercase">Mix Team</span>
                                <span class="text-[9px] text-slate-500 font-bold">•</span>
                                <span class="text-[9px] text-slate-400 font-bold">vs <?= esc($game['lawan_nama'] ?: 'Tim Lawan') ?></span>
                            <?php else: ?>
                                <span class="text-[9px] px-1.5 py-0.5 bg-brand-500/10 text-brand-400 border border-brand-500/20 rounded font-black tracking-wide uppercase">Kualifikasi</span>
                                <span class="text-[9px] text-slate-500 font-bold">•</span>
                                <span class="text-[9px] text-slate-400 font-bold"><?= $game['jumlah_sesi'] ?> Sesi</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="text-right select-none">
                        <?php if ($game['tipe_game'] === 'aduan' || $game['tipe_game'] === 'mixteam'): ?>
                            <?php if (($game['divisi'] ?? 'recurve') === 'compound'): ?>
                                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-wide">Skor Akhir</span>
                                <span class="text-sm font-extrabold text-amber-400 block mt-0.5"><?= $game['total_score'] ?> - <?= $game['total_score_lawan'] ?></span>
                            <?php else: ?>
                                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-wide">Poin Set</span>
                                <span class="text-sm font-extrabold text-amber-400 block mt-0.5"><?= $game['set_point_atlet'] ?> - <?= $game['set_point_lawan'] ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-[8px] font-bold text-slate-500 uppercase tracking-wide">Total Skor</span>
                            <span class="text-sm font-extrabold text-emerald-400 block mt-0.5"><?= $game['total_score'] ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="/panahan/game/<?= $game['id'] ?>" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-750 flex items-center justify-center text-slate-400 hover:text-white transition-all">
                        <i class='bx bx-chevron-right text-xl'></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function showNewGameForm() {
        const panel = document.getElementById('new-game-panel');
        panel.classList.remove('hidden');
        document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').focus();
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideNewGameForm() {
        document.getElementById('new-game-panel').classList.add('hidden');
    }

    var allOpponents = <?= json_encode($opponents) ?>;
    var currentAthlete = <?= json_encode($anggota) ?>;

    function toggleGameType(val) {
        const sesiGroup = document.getElementById('jumlah-sesi-group');
        const opponentGroup = document.getElementById('opponent-group');
        const divisiGroup = document.getElementById('divisi-group');
        const partnerGroup = document.getElementById('partner-group');
        const labelLawanNama = document.getElementById('label_lawan_nama');
        
        if (val === 'aduan') {
            sesiGroup.classList.add('hidden');
            opponentGroup.classList.remove('hidden');
            divisiGroup.classList.remove('hidden');
            partnerGroup.classList.add('hidden');
            labelLawanNama.innerHTML = 'Nama Lawan <span class="text-rose-500">*</span>';
            populateOpponents('aduan');
        } else if (val === 'mixteam') {
            sesiGroup.classList.add('hidden');
            opponentGroup.classList.remove('hidden');
            divisiGroup.classList.add('hidden'); // Divisi follows current athlete
            
            // Set the divisi value manually so it submits the correct division
            if (currentAthlete && currentAthlete.divisi) {
                document.getElementById('divisi').value = currentAthlete.divisi;
            }

            partnerGroup.classList.remove('hidden');
            labelLawanNama.innerHTML = 'Nama Tim Lawan <span class="text-rose-500">*</span>';
            
            // Force manual mode for mixteam opponent, hide database option temporarily
            document.querySelector('input[name="lawan_select_type"][value="manual"]').checked = true;
            document.querySelector('input[name="lawan_select_type"][value="database"]').parentElement.classList.add('hidden');
            toggleLawanInputMode('manual');
            
            populatePartners();
        } else {
            sesiGroup.classList.remove('hidden');
            opponentGroup.classList.add('hidden');
            divisiGroup.classList.add('hidden');
            partnerGroup.classList.add('hidden');
            // Reset radio to visible
            document.querySelector('input[name="lawan_select_type"][value="database"]').parentElement.classList.remove('hidden');
        }
    }

    function populateOpponents(mode) {
        const select = document.getElementById('lawan_id');
        select.innerHTML = '<option value="">-- Pilih Lawan --</option>';
        
        let filtered = allOpponents;
        if (mode === 'aduan') {
            // Same division, same gender
            filtered = allOpponents.filter(o => 
                o.divisi === currentAthlete.divisi && 
                o.jenis_kelamin === currentAthlete.jenis_kelamin
            );
        }

        filtered.forEach(opp => {
            select.innerHTML += `<option value="${opp.id}">${opp.nama} (${opp.klub || 'Tanpa Klub'})</option>`;
        });
    }

    function populatePartners() {
        const select = document.getElementById('partner_id');
        select.innerHTML = '<option value="">-- Pilih Partner --</option>';
        
        // Same division, DIFFERENT gender
        let filtered = allOpponents.filter(o => 
            o.divisi === currentAthlete.divisi && 
            o.jenis_kelamin !== currentAthlete.jenis_kelamin &&
            o.jenis_kelamin != null && o.jenis_kelamin !== ''
        );

        filtered.forEach(opp => {
            select.innerHTML += `<option value="${opp.id}">${opp.nama} (${opp.klub || 'Tanpa Klub'})</option>`;
        });
    }

    function toggleLawanInputMode(val) {
        const dbInput = document.getElementById('opponent-db-input');
        const manualInput = document.getElementById('opponent-manual-input');
        
        if (val === 'manual') {
            dbInput.classList.add('hidden');
            manualInput.classList.remove('hidden');
            document.getElementById('lawan_id').value = '';
        } else {
            dbInput.classList.remove('hidden');
            manualInput.classList.add('hidden');
            document.getElementById('lawan_nama').value = '';
        }
    }

    function createNewGame(event) {
        event.preventDefault();

        const tipeGame = document.getElementById('tipe_game').value;
        const lawanId = document.getElementById('lawan_id').value;
        const lawanNama = document.getElementById('lawan_nama').value;
        const partnerId = document.getElementById('partner_id') ? document.getElementById('partner_id').value : '';

        // Validation for Opponent
        if (tipeGame === 'aduan') {
            const inputMode = document.querySelector('input[name="lawan_select_type"]:checked').value;
            if (inputMode === 'database' && !lawanId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lawan Belum Dipilih',
                    text: 'Silakan pilih lawan bertanding terlebih dahulu!',
                    background: '#1e293b',
                    color: '#f8fafc',
                    confirmButtonColor: '#8b5cf6'
                });
                return;
            }
            if (inputMode === 'manual' && !lawanNama.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama Lawan Kosong',
                    text: 'Silakan masukkan nama lawan bertanding!',
                    background: '#1e293b',
                    color: '#f8fafc',
                    confirmButtonColor: '#8b5cf6'
                });
                return;
            }
        }

        const formData = new FormData();
        formData.append('anggota_id', document.getElementById('anggota_id').value);
        formData.append('tanggal', document.getElementById('tanggal').value);
        formData.append('tipe_game', tipeGame);
        formData.append('jumlah_sesi', document.getElementById('jumlah_sesi').value);
        formData.append('lawan_id', lawanId);
        formData.append('lawan_nama', lawanNama);
        formData.append('divisi', document.getElementById('divisi').value);
        formData.append('keterangan', document.getElementById('keterangan').value);
        if (tipeGame === 'mixteam') {
            formData.append('partner_id', partnerId);
        }

        // Show custom transparent sports loader
        showLoading('MENYIAPKAN GAME', 'Membuat formulir scoring di database...');

        fetch('/panahan/create', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            hideLoading();
            Swal.close();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Form Game Terbuat!',
                    text: data.message,
                    background: '#1e293b',
                    color: '#f8fafc',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = `/panahan/game/${data.gameId}`;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Membuat Game',
                    text: data.message,
                    background: '#1e293b',
                    color: '#f8fafc',
                    confirmButtonColor: '#8b5cf6'
                });
            }
        })
        .catch(err => {
            hideLoading();
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error Sistem',
                text: 'Terjadi kegagalan jaringan saat membuat game.',
                background: '#1e293b',
                color: '#f8fafc',
                confirmButtonColor: '#8b5cf6'
            });
        });
    }
</script>

<?= $this->endSection() ?>
