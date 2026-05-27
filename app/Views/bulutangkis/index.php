<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Intro -->
<div class="mb-5 select-none">
    <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider">Modul Scoring Bulutangkis</span>
    <h2 class="text-xl font-bold text-white mt-0.5">Pilih Atlet</h2>
    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Silakan pilih salah satu atlet di bawah ini untuk melihat riwayat permainan atau memulai pertandingan baru.</p>
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
            <div class="bg-slate-800/30 border border-slate-800/80 p-4 rounded-3xl hover:border-slate-700 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold text-sm shrink-0 shadow-sm">
                        <?= strtoupper(substr($person['nama'], 0, 2)) ?>
                    </div>
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

<?= $this->endSection() ?>
