<?php 
    $activeCabor = session()->get('active_cabor') ?? ''; 
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Full Width Header Image (Touches edges and top header) -->
<div class="relative -mx-4 -mt-4 animate-[slideDown_0.5s_ease-out]">
    <img src="/appsbee_header.png" alt="Appsbee Header" class="w-full h-auto object-contain drop-shadow-lg" />
</div>

<!-- Header Intro with Animation -->
<!-- Negative top margin (-mt-32) pulls this text up heavily so it overlaps higher up on the image -->
<div class="relative z-10 -mt-32 mb-10 select-none animate-[slideDown_0.6s_ease-out] flex flex-col items-center text-center">
    <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-lg">Modul Scoring</h2>
    <p class="text-xs text-slate-300 mt-2.5 leading-relaxed max-w-[90%] drop-shadow-md">Pilih cabang olahraga di bawah ini untuk memulai pencatatan statistik dan skor pertandingan secara presisi.</p>
</div>

<!-- Sports Grid (Vibrant Full-Color Cards) -->
<div class="flex flex-col gap-5 mb-8">
    
    <?php
    $sports = [
        [
            'name' => 'Panahan', 
            'icon' => 'bx-target-lock', 
            'gradient' => 'from-violet-600 via-fuchsia-600 to-rose-500', 
            'shadow' => 'shadow-fuchsia-500/40',
            'desc' => 'Scoring Target & Aduan'
        ],
        [
            'name' => 'Bulutangkis', 
            'icon' => 'shuttlecock', 
            'gradient' => 'from-emerald-500 via-teal-500 to-cyan-600', 
            'shadow' => 'shadow-teal-500/40',
            'desc' => 'Scoring Rally Point'
        ]
    ];
    
    $delay = 0;
    foreach ($sports as $sport):
        $isActive = (strtolower($activeCabor) === strtolower($sport['name']));
        $delay += 150;
    ?>
    <a href="/sports/select/<?= esc($sport['name']) ?>" style="animation-delay: <?= $delay ?>ms;" class="group relative overflow-hidden rounded-[2rem] flex flex-col p-6 transition-all duration-500 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl <?= $sport['shadow'] ?> active:scale-95 animate-[slideUp_0.6s_ease-out_both] <?= $isActive ? 'ring-4 ring-white/30' : '' ?>">
        
        <!-- Vibrant Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br <?= $sport['gradient'] ?> opacity-90 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Animated Background Pattern / Particles -->
        <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=')] bg-[length:16px_16px] group-hover:scale-110 transition-transform duration-700"></div>
        
        <!-- Giant Background Icon -->
        <?php if ($sport['icon'] === 'shuttlecock'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute -bottom-6 -right-4 w-32 h-32 text-white/10 group-hover:text-white/20 group-hover:rotate-12 transition-all duration-700">
                <path d="M12 2v2"/><path d="m8.5 3 1.5 2"/><path d="m15.5 3-1.5 2"/><path d="M12 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="m5.5 13 4-8.5"/><path d="m18.5 13-4-8.5"/><path d="M5.5 13c1.7 0 2.5 1.5 3.5 3.5"/><path d="M18.5 13c-1.7 0-2.5 1.5-3.5 3.5"/>
            </svg>
        <?php else: ?>
            <i class='bx <?= $sport['icon'] ?> absolute -bottom-6 -right-4 text-9xl text-white/10 group-hover:text-white/20 group-hover:rotate-12 transition-all duration-700'></i>
        <?php endif; ?>

        <!-- Content Container (Glassmorphic) -->
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <!-- Icon Box -->
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white mb-4 shadow-inner group-hover:bg-white/30 transition-colors duration-300">
                    <?php if ($sport['icon'] === 'shuttlecock'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-3xl group-hover:scale-110 transition-transform duration-300">
                            <path d="M12 2v2"/><path d="m8.5 3 1.5 2"/><path d="m15.5 3-1.5 2"/><path d="M12 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="m5.5 13 4-8.5"/><path d="m18.5 13-4-8.5"/><path d="M5.5 13c1.7 0 2.5 1.5 3.5 3.5"/><path d="M18.5 13c-1.7 0-2.5 1.5-3.5 3.5"/>
                        </svg>
                    <?php else: ?>
                        <i class='bx <?= $sport['icon'] ?> text-3xl group-hover:scale-110 transition-transform duration-300'></i>
                    <?php endif; ?>
                </div>
                
                <h3 class="text-2xl font-black text-white tracking-wide mb-1 drop-shadow-md"><?= esc($sport['name']) ?></h3>
                <p class="text-xs font-semibold text-white/80 drop-shadow-sm flex items-center gap-1.5">
                    <i class='bx bx-check-shield'></i> <?= esc($sport['desc']) ?>
                </p>
            </div>
            
            <!-- Arrow / Active Indicator -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 group-hover:bg-white/20 transition-all duration-300">
                <?php if ($isActive): ?>
                    <i class='bx bx-check text-2xl text-white drop-shadow-md animate-[bounce_2s_infinite]'></i>
                <?php else: ?>
                    <i class='bx bx-right-arrow-alt text-2xl text-white group-hover:translate-x-1 transition-transform duration-300'></i>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($isActive): ?>
            <!-- Active Badge -->
            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 px-3 py-1 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                <span class="text-[9px] font-black text-white tracking-widest uppercase">Aktif</span>
            </div>
        <?php endif; ?>
        
    </a>
    <?php endforeach; ?>

</div>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?= $this->endSection() ?>
