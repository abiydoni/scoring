<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Intro -->
<div class="mb-5 select-none">
    <span class="text-xs font-semibold text-brand-400 uppercase tracking-wider">Cabang Olahraga</span>
    <h2 class="text-xl font-bold text-white mt-0.5">Pilih Modul Scoring</h2>
    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Silakan pilih cabang olahraga di bawah ini untuk memulai pencatatan dan penilaian skor latihan.</p>
</div>

<!-- Sports Grid (2 Columns, Android Premium Feel) -->
<div class="grid grid-cols-2 gap-4 mb-6">
    
    <!-- Sport: Panahan (Active) -->
    <a href="/panahan" class="group bg-slate-800/40 hover:bg-slate-800/70 border border-brand-500/20 hover:border-brand-500/50 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 shadow-lg shadow-brand-500/5 min-h-[140px] relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-16 h-16 bg-brand-500/10 rounded-full blur-xl group-hover:bg-brand-500/20 transition-all"></div>
        <div class="w-14 h-14 rounded-2xl bg-brand-500/15 border border-brand-500/30 flex items-center justify-center text-brand-400 mb-3 group-hover:scale-110 transition-all shadow-inner shadow-brand-500/10">
            <i class='bx bx-target-lock text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-white block">Panahan</span>
        <span class="text-[10px] text-brand-400 mt-1 font-semibold block px-2.5 py-0.5 bg-brand-500/10 rounded-full border border-brand-500/25">Aktif</span>
    </a>

    <!-- Sport: Menembak (Coming Soon) -->
    <button onclick="showComingSoon('Menembak')" class="group bg-slate-800/20 border border-slate-800/60 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 min-h-[140px] relative overflow-hidden select-none">
        <div class="absolute right-3 top-3 text-slate-600 text-sm">
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-slate-850 border border-slate-800/40 flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 transition-all">
            <i class='bx bx-bullseye text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-slate-400 block">Menembak</span>
        <span class="text-[9px] text-slate-500 mt-1.5 font-medium block">Segera Hadir</span>
    </button>

    <!-- Sport: Basket (Coming Soon) -->
    <button onclick="showComingSoon('Bola Basket')" class="group bg-slate-800/20 border border-slate-800/60 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 min-h-[140px] relative overflow-hidden select-none">
        <div class="absolute right-3 top-3 text-slate-600 text-sm">
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-slate-850 border border-slate-800/40 flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 transition-all">
            <i class='bx bx-basketball text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-slate-400 block">Bola Basket</span>
        <span class="text-[9px] text-slate-500 mt-1.5 font-medium block">Segera Hadir</span>
    </button>

    <!-- Sport: Bulu Tangkis (Coming Soon) -->
    <button onclick="showComingSoon('Bulu Tangkis')" class="group bg-slate-800/20 border border-slate-800/60 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 min-h-[140px] relative overflow-hidden select-none">
        <div class="absolute right-3 top-3 text-slate-600 text-sm">
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-slate-850 border border-slate-800/40 flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 transition-all">
            <i class='bx bx-tennis-ball text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-slate-400 block">Bulu Tangkis</span>
        <span class="text-[9px] text-slate-500 mt-1.5 font-medium block">Segera Hadir</span>
    </button>

    <!-- Sport: Bowling (Coming Soon) -->
    <button onclick="showComingSoon('Bowling')" class="group bg-slate-800/20 border border-slate-800/60 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 min-h-[140px] relative overflow-hidden select-none">
        <div class="absolute right-3 top-3 text-slate-600 text-sm">
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-slate-850 border border-slate-800/40 flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 transition-all">
            <i class='bx bx-bowling-ball text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-slate-400 block">Bowling</span>
        <span class="text-[9px] text-slate-500 mt-1.5 font-medium block">Segera Hadir</span>
    </button>

    <!-- Sport: Panjat Tebing (Coming Soon) -->
    <button onclick="showComingSoon('Panjat Tebing')" class="group bg-slate-800/20 border border-slate-800/60 p-4 rounded-3xl flex flex-col items-center justify-center text-center transition-all duration-300 transform active:scale-95 min-h-[140px] relative overflow-hidden select-none">
        <div class="absolute right-3 top-3 text-slate-600 text-sm">
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-slate-850 border border-slate-800/40 flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 transition-all">
            <i class='bx bx-landscape text-3xl'></i>
        </div>
        <span class="text-sm font-bold text-slate-400 block">Panjat Tebing</span>
        <span class="text-[9px] text-slate-500 mt-1.5 font-medium block">Segera Hadir</span>
    </button>

</div>

<script>
    function showComingSoon(sportName) {
        Swal.fire({
            title: sportName,
            text: `Modul scoring untuk ${sportName} sedang dalam tahap pengembangan dan akan segera tersedia pada pembaruan aplikasi berikutnya.`,
            icon: 'info',
            background: '#1e293b',
            color: '#f8fafc',
            confirmButtonColor: '#8b5cf6',
            confirmButtonText: 'Siap, Ditunggu!'
        });
    }
</script>

<?= $this->endSection() ?>
