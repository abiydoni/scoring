<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-xl font-bold bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent mb-1">
        Pengaturan
    </h2>
    <p class="text-sm text-slate-400">Konfigurasi dan pemeliharaan sistem.</p>
</div>

<div class="space-y-4">
    <!-- Database Backup Section -->
    <div class="bg-slate-800/40 border border-slate-700/50 rounded-2xl p-5 hover:bg-slate-800/60 transition-all group overflow-hidden relative">
        <!-- Decoration -->
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-brand-500/10 rounded-full blur-xl group-hover:bg-brand-500/20 transition-all"></div>
        
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-brand-500/20 shrink-0">
                <i class='bx bx-data text-2xl text-white'></i>
            </div>
            <div>
                <h3 class="text-slate-200 font-semibold text-lg leading-tight">Backup Database</h3>
                <p class="text-xs text-slate-400 mt-1">Unduh seluruh data scoring dan riwayat permainan dalam format SQLite3.</p>
            </div>
        </div>
        
        <div class="relative z-10">
            <a href="/settings/backup" class="flex items-center justify-center gap-2 w-full py-3 bg-brand-500 hover:bg-brand-400 text-white rounded-xl font-bold transition-all shadow-lg shadow-brand-500/30 group-active:scale-[0.98]" download>
                <i class='bx bx-cloud-download text-xl'></i> Unduh Backup Sekarang
            </a>
        </div>
    </div>
    
    <!-- Placeholder for Future Features -->
    <div class="bg-slate-800/20 border border-slate-700/30 border-dashed rounded-2xl p-6 text-center opacity-70">
        <div class="w-12 h-12 rounded-full bg-slate-800/50 flex items-center justify-center mx-auto mb-3">
            <i class='bx bx-bulb text-2xl text-slate-500'></i>
        </div>
        <h3 class="text-slate-400 font-medium text-sm">Fitur Tambahan</h3>
        <p class="text-xs text-slate-500 mt-1">Pengaturan lainnya akan ditambahkan di sini di masa mendatang.</p>
    </div>
</div>

<?= $this->endSection() ?>
