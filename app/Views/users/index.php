<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-xl font-bold bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent mb-1">
        Pengguna Aktif
    </h2>
    <p class="text-sm text-slate-400">Daftar pengguna aplikasi dan status online terakhir.</p>
</div>

<div class="space-y-4">
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
            <div class="bg-slate-800/40 border <?= $isOnline ? 'border-brand-500/30' : 'border-slate-700/50' ?> rounded-2xl p-4 flex items-center justify-between hover:bg-slate-800/60 transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full <?= $isOnline ? 'bg-brand-500/20 text-brand-400' : 'bg-slate-700/50 text-slate-400' ?> flex items-center justify-center relative">
                        <i class='bx bx-user text-xl'></i>
                        <?php if ($isOnline): ?>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-200"><?= esc($user['email']) ?></h3>
                        <p class="text-[10px] text-slate-500 mt-0.5">Mendaftar: <?= date('d M Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
                <div class="text-right flex flex-col items-end">
                    <?php if ($isOnline): ?>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Online
                        </span>
                    <?php else: ?>
                        <span class="text-xs font-semibold text-slate-400"><?= $statusText ?></span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
