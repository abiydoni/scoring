<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Profile -->
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="/bulutangkis" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
            <i class='bx bx-arrow-back'></i>
        </a>
        <div>
            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest block mb-0.5">Riwayat Bulutangkis</span>
            <h2 class="text-xl font-bold text-white"><?= esc($atlet['nama']) ?></h2>
        </div>
    </div>
</div>

<!-- Start New Game Card -->
<div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-[2rem] p-5 mb-8 relative overflow-hidden shadow-lg shadow-emerald-900/20">
    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
    <div class="relative z-10 flex items-center justify-between">
        <div class="pr-4">
            <h3 class="text-lg font-bold text-white mb-1">Mulai Pertandingan</h3>
            <p class="text-xs text-emerald-100/80 leading-relaxed">Pilih lawan dan catat skor pertandingan secara real-time.</p>
        </div>
        <button onclick="document.getElementById('newGameModal').classList.remove('hidden')" class="w-12 h-12 rounded-full bg-white text-emerald-600 flex items-center justify-center text-2xl shrink-0 shadow-lg hover:scale-105 active:scale-95 transition-transform">
            <i class='bx bx-play ml-1'></i>
        </button>
    </div>
</div>

<!-- Match History List -->
<div class="mb-4 flex items-center justify-between">
    <h3 class="text-sm font-bold text-white">Riwayat Terakhir</h3>
    <span class="text-[10px] font-bold bg-slate-800 text-slate-400 px-2.5 py-1 rounded-lg"><?= count($matches) ?> Game</span>
</div>

<div class="space-y-4">
    <?php if (empty($matches)): ?>
        <div class="text-center py-10 bg-slate-800/30 rounded-3xl border border-dashed border-slate-700">
            <i class='bx bx-history text-4xl text-slate-600 mb-2'></i>
            <p class="text-xs text-slate-500 font-medium">Belum ada riwayat pertandingan.</p>
        </div>
    <?php else: ?>
        <?php foreach ($matches as $match): ?>
            <?php 
                $isWin = ($match['set_menang_atlet'] > $match['set_menang_lawan']);
                $isDraw = ($match['set_menang_atlet'] == $match['set_menang_lawan']);
                $resultColor = $isWin ? 'emerald' : ($isDraw ? 'slate' : 'rose');
                $resultIcon = $isWin ? 'bx-trophy' : ($isDraw ? 'bx-minus' : 'bx-x');
                $resultText = $isWin ? 'MENANG' : ($isDraw ? 'SERI' : 'KALAH');
            ?>
            <a href="/bulutangkis/scoring/<?= $match['id'] ?>" class="block bg-slate-800/40 border border-slate-700/50 p-4 rounded-3xl relative overflow-hidden group hover:border-slate-600 transition-colors">
                <!-- Result Accent -->
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-<?= $resultColor ?>-500"></div>
                
                <div class="flex items-center justify-between mb-3 pl-2">
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-bold text-slate-400 bg-slate-800 px-2 py-0.5 rounded uppercase"><?= esc($match['tipe_match']) ?></span>
                        <span class="text-[10px] text-slate-500 font-medium"><?= date('d M Y', strtotime($match['tanggal'])) ?></span>
                    </div>
                    <?php if ($match['status'] === 'ongoing'): ?>
                        <span class="text-[9px] font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-full flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> ONGOING</span>
                    <?php else: ?>
                        <span class="text-[10px] font-black text-<?= $resultColor ?>-400 flex items-center gap-1">
                            <i class='bx <?= $resultIcon ?>'></i> <?= $resultText ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="pl-2 flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-white">
                                <?= esc($atlet['nama']) ?>
                                <?= $match['tipe_match'] === 'Ganda' && !empty($match['partner_nama_db']) ? ' & ' . esc($match['partner_nama_db']) : '' ?>
                            </span>
                            <span class="text-lg font-black text-white"><?= $match['set_menang_atlet'] ?></span>
                        </div>
                        <div class="flex items-center justify-between opacity-60">
                            <span class="text-sm font-semibold text-slate-300">
                                <?php 
                                    $lawanName = $match['lawan_id'] ? esc($match['lawan_nama']) : ($match['lawan_nama'] ? esc($match['lawan_nama']) : 'Lawan Anonim');
                                    if ($match['tipe_match'] === 'Ganda') {
                                        $lawanPartner = $match['lawan_partner_id'] ? esc($match['lawan_partner_nama_db']) : esc($match['lawan_partner_nama']);
                                        if ($lawanPartner) {
                                            $lawanName .= ' & ' . $lawanPartner;
                                        }
                                    }
                                    echo $lawanName;
                                ?>
                            </span>
                            <span class="text-lg font-black text-slate-300"><?= $match['set_menang_lawan'] ?></span>
                        </div>
                    </div>
                    <div class="w-10 flex justify-end text-slate-600 group-hover:text-slate-400 transition-colors">
                        <i class='bx bx-chevron-right text-2xl'></i>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal Create Game -->
<div id="newGameModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="document.getElementById('newGameModal').classList.add('hidden')"></div>
    
    <!-- Modal Content -->
    <div class="absolute bottom-0 inset-x-0 bg-slate-900 border-t border-slate-800 rounded-t-[2rem] p-6 animate-[slideUp_0.3s_ease-out]">
        <div class="w-12 h-1.5 bg-slate-800 rounded-full mx-auto mb-6"></div>
        
        <h3 class="text-lg font-bold text-white mb-6">Pengaturan Pertandingan</h3>
        
        <form action="/bulutangkis/create" method="POST" class="space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="anggota_id" value="<?= $atlet['id'] ?>">
            
            <!-- 1. Tipe Pertandingan -->
            <div>
                <label for="tipe_match" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tipe Pertandingan <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-category text-base'></i>
                    </div>
                    <select id="tipe_match" name="tipe_match" onchange="toggleDoublesMode(this.value)" required class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                        <option value="Tunggal">Tunggal (Singles)</option>
                        <option value="Ganda">Ganda (Doubles)</option>
                    </select>
                </div>
            </div>

            <!-- 1.5. Partner (Only shown if Ganda) -->
            <div id="partner-group" class="hidden">
                <label for="partner_id" class="block text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-1.5">Pasangan Anda (Tim Kita) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class='bx bx-user-plus text-base'></i>
                    </div>
                    <select id="partner_id" name="partner_id" class="w-full pl-10 pr-4 py-2.5 bg-emerald-900/10 border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                        <option value="">-- Pilih Partner --</option>
                        <?php foreach($calon_lawan as $cl): ?>
                            <option value="<?= $cl['id'] ?>"><?= esc($cl['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- 2. Lawan -->
            <div id="opponent-group" class="space-y-3.5">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Cara Input Lawan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                            <input type="radio" name="lawan_select_type" value="database" checked onchange="toggleLawanMode(this.value)" class="text-emerald-500 focus:ring-emerald-500 bg-slate-950 border-slate-800">
                            <span>Dari Atlet Terdaftar</span>
                        </label>
                        <label class="flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                            <input type="radio" name="lawan_select_type" value="manual" onchange="toggleLawanMode(this.value)" class="text-emerald-500 focus:ring-emerald-500 bg-slate-950 border-slate-800">
                            <span>Input Manual</span>
                        </label>
                    </div>
                </div>

                <!-- Opponent Dropdown (From DB) -->
                <div id="lawan-db-input" class="space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user-voice text-base'></i>
                        </div>
                        <select id="lawan_id" name="lawan_id" class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="">-- Pilih Lawan 1 --</option>
                            <?php foreach($calon_lawan as $cl): ?>
                                <option value="<?= $cl['id'] ?>"><?= esc($cl['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Partner Lawan DB (Hidden by default) -->
                    <div id="lawan-partner-db-input" class="relative hidden">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user-plus text-base'></i>
                        </div>
                        <select id="lawan_partner_id" name="lawan_partner_id" class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="">-- Pilih Lawan 2 (Partner) --</option>
                            <?php foreach($calon_lawan as $cl): ?>
                                <option value="<?= $cl['id'] ?>"><?= esc($cl['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Opponent Name (Manual Text Field) -->
                <div id="lawan-manual-input" class="hidden space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user text-base'></i>
                        </div>
                        <input type="text" id="lawan_nama" name="lawan_nama" placeholder="Masukkan nama lawan 1" class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none">
                    </div>
                    
                    <!-- Partner Lawan Manual (Hidden by default) -->
                    <div id="lawan-partner-manual-input" class="relative hidden">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class='bx bx-user-plus text-base'></i>
                        </div>
                        <input type="text" id="lawan_partner_nama" name="lawan_partner_nama" placeholder="Masukkan nama lawan 2 (Partner)" class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full mt-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-emerald-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <i class='bx bx-check-circle text-lg'></i>
                <span>Mulai Scoring</span>
            </button>
        </form>
    </div>
</div>

<script>
function toggleLawanMode(mode) {
    const dbInput = document.getElementById('lawan-db-input');
    const manualInput = document.getElementById('lawan-manual-input');
    const selectDb = document.getElementById('lawan_id');
    const inputManual = document.getElementById('lawan_nama');

    if (mode === 'database') {
        dbInput.classList.remove('hidden');
        manualInput.classList.add('hidden');
        selectDb.required = true;
        inputManual.required = false;
        inputManual.value = ''; // clear manual
        document.getElementById('lawan_partner_nama').value = '';
    } else {
        dbInput.classList.add('hidden');
        manualInput.classList.remove('hidden');
        selectDb.required = false;
        inputManual.required = true;
        selectDb.value = ''; // clear select
        document.getElementById('lawan_partner_id').value = '';
    }
}

function toggleDoublesMode(tipe) {
    const partnerGroup = document.getElementById('partner-group');
    const partnerId = document.getElementById('partner_id');
    
    const lawanPartnerDb = document.getElementById('lawan-partner-db-input');
    const lawanPartnerId = document.getElementById('lawan_partner_id');
    
    const lawanPartnerManual = document.getElementById('lawan-partner-manual-input');
    const lawanPartnerNama = document.getElementById('lawan_partner_nama');
    
    if (tipe === 'Ganda') {
        partnerGroup.classList.remove('hidden');
        partnerId.required = true;
        
        lawanPartnerDb.classList.remove('hidden');
        lawanPartnerManual.classList.remove('hidden');
        
        // We only require one of them depending on mode, but to be simple we can skip hard html require and let controller handle it, 
        // or just apply require dynamically. Let's just remove required for partner lawn since they might not know it yet.
    } else {
        partnerGroup.classList.add('hidden');
        partnerId.required = false;
        partnerId.value = '';
        
        lawanPartnerDb.classList.add('hidden');
        lawanPartnerId.value = '';
        
        lawanPartnerManual.classList.add('hidden');
        lawanPartnerNama.value = '';
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    toggleLawanMode('database');
    toggleDoublesMode(document.getElementById('tipe_match').value);
});
</script>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(100%); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?= $this->endSection() ?>
