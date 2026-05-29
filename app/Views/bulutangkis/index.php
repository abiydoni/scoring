<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Intro -->
<div class="mb-5 select-none">
    <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider">Modul Scoring Bulutangkis</span>
    <h2 class="text-xl font-bold text-white mt-0.5">Pilih Atlet</h2>
    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Silakan pilih salah satu atlet di bawah ini untuk melihat riwayat permainan atau memulai pertandingan baru.</p>
</div>

<!-- Search Box -->
<div class="mb-4">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <i class='bx bx-search text-slate-400 text-lg'></i>
        </div>
        <input type="text" id="searchAthlete" onkeyup="filterAthletes()" class="w-full bg-slate-900/60 border border-slate-800 text-white text-sm rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block pl-10 pr-10 p-3.5 transition-all placeholder-slate-500 shadow-inner" placeholder="Ketik nama atlet untuk mencari...">
        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
            <i id="clearSearch" class='bx bx-x text-slate-400 text-2xl cursor-pointer hover:text-white hidden' onclick="clearSearchInput()"></i>
        </div>
    </div>
</div>

<!-- Athletes Table List (Mobile-First Style) -->
<div class="space-y-3">
    <?php if (empty($anggota)): ?>
        <div class="bg-slate-800/20 border border-dashed border-slate-800 py-12 px-4 rounded-3xl text-center text-slate-500 text-xs select-none">
            <i class='bx bx-user-x text-4xl text-slate-750 mb-2 block'></i>
            <span>Belum ada data atlet Bulutangkis terdaftar.<br>Silakan tambah atlet terlebih dahulu di menu "Atlet".</span>
        </div>
    <?php else: ?>
        <?php foreach ($anggota as $person): ?>
            <div class="athlete-card bg-slate-800/30 border border-slate-800/80 p-4 rounded-3xl hover:border-slate-700 transition-all flex items-center justify-between group" data-name="<?= esc(strtolower($person['nama'])) ?>">
                <div class="flex items-center gap-3">
                    <?php if (!empty($person['foto'])): ?>
                        <img src="/uploads/anggota/<?= esc($person['foto']) ?>" class="w-10 h-10 rounded-2xl object-cover border border-emerald-500/20 shadow-sm shrink-0">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold text-sm shrink-0 shadow-sm">
                            <?= strtoupper(substr($person['nama'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h4 class="text-sm font-bold text-white"><?= esc($person['nama']) ?></h4>
                        <span class="text-[9px] text-slate-500 font-semibold block mt-0.5 uppercase tracking-wide">Badminton Athlete</span>
                    </div>
                </div>
                
                <a href="/bulutangkis/riwayat/<?= $person['id'] ?>" class="px-3.5 py-2 bg-emerald-600/10 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/15 hover:border-emerald-500 rounded-2xl transition-all text-xs font-bold flex items-center gap-1 active:scale-95 duration-200 shadow-sm shadow-emerald-500/5">
                    <span>Pilih</span>
                    <i class='bx bx-chevron-right text-base'></i>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function filterAthletes() {
    let input = document.getElementById('searchAthlete');
    let filter = input.value.toLowerCase();
    let athleteCards = document.querySelectorAll('.athlete-card');
    let clearBtn = document.getElementById('clearSearch');
    
    if (filter.length > 0) {
        clearBtn.classList.remove('hidden');
    } else {
        clearBtn.classList.add('hidden');
    }
    
    athleteCards.forEach(card => {
        let name = card.getAttribute('data-name');
        if (name.includes(filter)) {
            card.style.setProperty("display", "flex", "important");
        } else {
            card.style.setProperty("display", "none", "important");
        }
    });
}

function clearSearchInput() {
    let input = document.getElementById('searchAthlete');
    input.value = '';
    filterAthletes();
    input.focus();
}
</script>

<?= $this->endSection() ?>
