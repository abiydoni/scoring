<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="mb-6 flex items-start justify-between gap-3">
    <div>
        <h2 class="text-xl font-bold bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent mb-1">
            Pengguna Aktif
        </h2>
        <p class="text-sm text-slate-400">Daftar pengguna aplikasi dan status online terakhir.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="/settings" title="Pengaturan" class="w-8 h-8 rounded-full bg-slate-800/50 border border-slate-700/50 text-slate-400 hover:text-white hover:bg-slate-700 flex items-center justify-center transition-all shadow-sm">
            <i class='bx bx-cog text-lg'></i>
        </a>
        <?php if (!empty($users)): ?>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-800/50 border border-slate-700/50 text-slate-300 text-[10px] font-bold uppercase tracking-wider shrink-0 shadow-sm">
                <i class='bx bx-group text-sm text-brand-400'></i> <?= count($users) ?> Total
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($users)): ?>
<!-- Search Box -->
<div class="mb-5 relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <i class='bx bx-search text-slate-400 text-lg'></i>
    </div>
    <input type="text" id="search-user" placeholder="Cari nama atau email..." class="w-full bg-slate-800/60 border border-slate-700/50 text-slate-200 text-sm rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 block pl-10 pr-10 p-2.5 transition-all shadow-sm placeholder-slate-500">
    <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
        <button type="button" id="clear-search" class="w-7 h-7 rounded-full text-slate-400 hover:text-white hover:bg-slate-700 flex items-center justify-center transition-all hidden">
            <i class='bx bx-x text-lg'></i>
        </button>
    </div>
</div>
<?php endif; ?>

<div class="space-y-4" id="users-container">
    <?php if (empty($users)): ?>
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mx-auto mb-3">
                <i class='bx bx-user-x text-3xl text-slate-500'></i>
            </div>
            <h3 class="text-slate-300 font-semibold mb-1">Belum Ada Pengguna</h3>
            <p class="text-xs text-slate-500">Belum ada pengguna yang memasukkan email.</p>
        </div>
    <?php else: ?>
        <?php foreach ($users as $user): 
            $lastOnline = strtotime($user['last_online']);
            $isOnline = (time() - $lastOnline) <= 300; // 5 minutes (300 seconds)
            
            // Format time diff nicely
            $diff = time() - $lastOnline;
            if ($isOnline) {
                $statusText = "Online";
            } elseif ($diff < 3600) {
                $mins = floor($diff / 60);
                $statusText = $mins . " menit lalu";
            } elseif ($diff < 86400) {
                $hours = floor($diff / 3600);
                $statusText = $hours . " jam lalu";
            } else {
                $days = floor($diff / 86400);
                $statusText = $days . " hari lalu";
            }
        ?>
            <div class="user-item bg-slate-800/40 border <?= $isOnline ? 'border-brand-500/30' : 'border-slate-700/50' ?> rounded-2xl p-4 flex items-center justify-between hover:bg-slate-800/60 transition-all group overflow-hidden" data-name="<?= esc(strtolower($user['name'] ?? '')) ?>" data-email="<?= esc(strtolower($user['email'])) ?>">
                <div class="flex items-center gap-3 overflow-hidden min-w-0">
                    <div class="w-10 h-10 rounded-full <?= $isOnline ? 'bg-brand-500/20 text-brand-400' : 'bg-slate-700/50 text-slate-400' ?> flex items-center justify-center relative shrink-0">
                        <?php if (!empty($user['picture'])): ?>
                            <img src="<?= esc($user['picture']) ?>" alt="Profile" class="w-full h-full rounded-full object-cover <?= $isOnline ? '' : 'grayscale opacity-80' ?>" referrerpolicy="no-referrer">
                        <?php else: ?>
                            <i class='bx bx-user text-xl'></i>
                        <?php endif; ?>
                        
                        <?php if ($isOnline): ?>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full z-10"></div>
                        <?php endif; ?>
                    </div>
                    <div class="truncate pr-2">
                        <h3 class="text-sm font-semibold text-slate-200 truncate">
                            <?= !empty($user['name']) ? esc($user['name']) : esc($user['email']) ?>
                        </h3>
                        <p class="text-[10px] text-slate-500 mt-0.5 truncate">
                            <?= !empty($user['name']) ? esc($user['email']) . ' &bull; ' : '' ?>Mendaftar: <?= date('d M', strtotime($user['created_at'])) ?>
                        </p>
                    </div>
                </div>
                <div class="text-right flex items-center gap-2">
                    <?php if ($isOnline): ?>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Online
                        </span>
                    <?php else: ?>
                        <span class="text-xs font-semibold text-slate-400"><?= $statusText ?></span>
                    <?php endif; ?>
                    <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= esc($user['email']) ?>')"
                        class="w-7 h-7 rounded-full bg-slate-700/50 hover:bg-rose-500/20 flex items-center justify-center text-slate-500 hover:text-rose-400 transition-all opacity-0 group-hover:opacity-100">
                        <i class='bx bx-x text-base'></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function confirmDelete(id, email) {
        Swal.fire({
            title: 'Hapus User?',
            html: `Hapus <strong>${email}</strong> dari daftar pengguna?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            background: document.documentElement.classList.contains('light-mode') ? '#ffffff' : '#1e293b',
            color: document.documentElement.classList.contains('light-mode') ? '#0f172a' : '#f8fafc',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/users/delete/${id}`;
            }
        });
    }

</script>

<!-- Search Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-user');
        const clearBtn = document.getElementById('clear-search');
        if (!searchInput) return;

        function filterUsers(term) {
            term = term.toLowerCase();
            const items = document.querySelectorAll('.user-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                const email = item.getAttribute('data-email');
                
                if (name.includes(term) || email.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Toggle clear button
            if (term.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        searchInput.addEventListener('input', function(e) {
            filterUsers(e.target.value);
        });
        
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterUsers('');
            searchInput.focus();
        });
    });
</script>

<?= $this->endSection() ?>
