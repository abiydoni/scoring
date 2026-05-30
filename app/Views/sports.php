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

<!-- Logged In Identity Card (Dynamic via JS) -->
<div id="user-identity-card" class="mb-6 mx-4 animate-[slideDown_0.6s_ease-out]">
    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-4 flex items-center gap-4 backdrop-blur-md relative overflow-hidden group hover:bg-slate-800/80 transition-all shadow-lg shadow-slate-900/40" id="identity-card-inner">
        <!-- Decoration -->
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-all"></div>
        
        <div id="user-identity-avatar" class="w-12 h-12 rounded-full bg-slate-700/50 flex items-center justify-center border-2 border-slate-600/50 shrink-0 relative z-10 overflow-hidden text-slate-400">
            <i class='bx bx-user text-xl'></i>
        </div>
        
        <div class="flex-1 min-w-0 relative z-10">
            <p id="user-identity-label" class="text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-0.5">Memuat...</p>
            <h4 id="user-identity-name" class="text-sm font-semibold text-slate-200 truncate">Harap Tunggu...</h4>
            <p id="user-identity-email" class="text-[11px] text-slate-500 truncate mt-0.5"></p>
        </div>
        
        <div id="user-identity-action" class="relative z-10 flex items-center gap-2">
            <!-- Buttons injected by JS -->
        </div>
    </div>
</div>

<!-- Script to populate identity -->
<script>
window.updateUserIdentityCard = () => {
    const email = localStorage.getItem('app_user_email');
    const name = localStorage.getItem('app_user_name');
    const picture = localStorage.getItem('app_user_picture');
    
    const card = document.getElementById('user-identity-card');
    const avatar = document.getElementById('user-identity-avatar');
    const labelEl = document.getElementById('user-identity-label');
    const nameEl = document.getElementById('user-identity-name');
    const emailEl = document.getElementById('user-identity-email');
    const actionEl = document.getElementById('user-identity-action');
    
    const sportCards = document.querySelectorAll('.sport-card');
    
    if (!avatar || !nameEl) return;
    
    if (email) {
        // LOGGED IN STATE
        if (picture) {
            avatar.innerHTML = `<img src="${picture}" class="w-full h-full object-cover" referrerpolicy="no-referrer">`;
            avatar.className = "w-12 h-12 rounded-full flex items-center justify-center border-2 shrink-0 relative z-10 overflow-hidden border-brand-500/50";
        } else {
            avatar.innerHTML = `<i class='bx bx-user text-xl'></i>`;
            avatar.className = "w-12 h-12 rounded-full flex items-center justify-center border-2 shrink-0 relative z-10 overflow-hidden bg-brand-500/20 text-brand-400 border-brand-500/30";
        }
        
        labelEl.className = "text-[10px] font-bold tracking-wider text-emerald-400 uppercase mb-0.5";
        labelEl.innerHTML = "<i class='bx bx-check-circle'></i> Berhasil Login";
        nameEl.textContent = name ? name : email;
        emailEl.textContent = name ? email : 'Akun Lokal';
        
        actionEl.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0" title="Terverifikasi">
                <i class='bx bx-check-shield text-lg'></i>
            </div>
            <button onclick="logoutUser()" title="Keluar Akun" class="w-8 h-8 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300 flex items-center justify-center shrink-0 transition-all">
                <i class='bx bx-log-out text-lg'></i>
            </button>
        `;
        
        // ENABLE CARDS
        sportCards.forEach(c => {
            c.classList.remove('grayscale', 'opacity-60', 'saturate-50');
            c.removeAttribute('data-locked');
        });
        
    } else {
        // LOGGED OUT STATE
        avatar.innerHTML = `<i class='bx bx-user-x text-xl'></i>`;
        avatar.className = "w-12 h-12 rounded-full flex items-center justify-center border-2 shrink-0 relative z-10 overflow-hidden bg-slate-700/50 border-slate-600/50 text-slate-400";
        
        labelEl.className = "text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-0.5";
        labelEl.textContent = 'Akses Terkunci';
        nameEl.textContent = 'Mode Tamu';
        emailEl.innerHTML = '<span class="text-brand-400 font-semibold animate-pulse">Login Google di sini 👉</span>';
        
        actionEl.innerHTML = `
            <div id="google-login-btn"></div>
        `;
        
        // Render actual Google Sign-In button (Bypasses One Tap Cooldown)
        const renderGButton = () => {
            const btnContainer = document.getElementById('google-login-btn');
            if (!btnContainer) return;
            
            if (typeof google !== 'undefined' && google.accounts && google.accounts.id) {
                google.accounts.id.initialize({
                    client_id: '215408546614-3et2rjsrmlm1pbt1q9m9emb4rv0l5g9j.apps.googleusercontent.com',
                    callback: (typeof handleGoogleCredentialResponse !== 'undefined') ? handleGoogleCredentialResponse : () => {}
                });
                google.accounts.id.renderButton(
                    btnContainer,
                    { theme: 'filled_black', size: 'medium', shape: 'pill', text: 'signin' }
                );
            } else {
                setTimeout(renderGButton, 200);
            }
        };
        renderGButton();
        
        // DISABLE CARDS
        sportCards.forEach(c => {
            c.classList.add('grayscale', 'opacity-60', 'saturate-50');
            c.setAttribute('data-locked', 'true');
            c.addEventListener('click', function lockedClickHandler(e) {
                if (c.getAttribute('data-locked') === 'true') {
                    e.preventDefault();
                    e.stopPropagation();
                    Swal.fire({
                        title: 'Akses Ditolak',
                        text: 'Silakan login menggunakan Google (atau Email) terlebih dahulu untuk bisa masuk ke modul scoring olahraga.',
                        icon: 'warning',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#0ea5e9',
                        background: document.documentElement.classList.contains('light-mode') ? '#ffffff' : '#1e293b',
                        color: document.documentElement.classList.contains('light-mode') ? '#0f172a' : '#f8fafc'
                    });
                }
            });
        });
    }
};

window.updateUserIdentityCard();
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.updateUserIdentityCard);
}
</script>

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
    <a href="/sports/select/<?= esc($sport['name']) ?>" style="animation-delay: <?= $delay ?>ms;" class="sport-card group relative overflow-hidden rounded-[2rem] flex flex-col p-6 transition-all duration-500 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl <?= $sport['shadow'] ?> active:scale-95 animate-[slideUp_0.6s_ease-out_both] <?= $isActive ? 'ring-4 ring-white/30' : '' ?>">
        
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
