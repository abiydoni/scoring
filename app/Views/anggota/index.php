<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Intro -->
<div class="flex justify-between items-center mb-5 select-none">
    <div>
        <span class="text-xs font-semibold text-brand-400 uppercase tracking-wider">Manajemen Atlet</span>
        <h2 class="text-xl font-bold text-white mt-0.5">Daftar Atlet</h2>
    </div>
    <button onclick="openAthleteModal('create')" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-2xl transition-all text-xs font-bold flex items-center gap-1.5 shadow-lg shadow-brand-500/20 active:scale-95 duration-200">
        <i class='bx bx-plus text-base'></i>
        <span>Atlet Baru</span>
    </button>
</div>
<!-- Athlete Form Modal -->
<div id="athlete-form-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-slate-800/90 light-modal p-6 rounded-3xl max-w-md w-full mx-4">
        <h3 id="form-modal-title" class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-4">Tambah Atlet Baru</h3>
        <form id="athlete-form" action="/anggota/store" method="POST">
            <div class="space-y-3.5">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Cabang Olahraga</label>
                        <input type="text" value="<?= esc($activeCabor ?? 'Panahan') ?>" readonly class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-2xl text-slate-400 text-xs cursor-not-allowed outline-none" />
                    </div>
                    <div>
                        <label for="nama" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <i class='bx bx-user text-base'></i>
                            </div>
                            <input type="text" id="nama" name="nama" required placeholder="Nama atlet" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none" />
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="telepon" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">No. Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <i class='bx bx-phone text-base'></i>
                            </div>
                            <input type="text" id="telepon" name="telepon" placeholder="Contoh: 0812..." class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none" />
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <i class='bx bx-envelope text-base'></i>
                            </div>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none" />
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="jenis_kelamin" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="">Pilih Gender</option>
                            <option value="L">Laki-laki (M)</option>
                            <option value="P">Perempuan (W)</option>
                        </select>
                    </div>
                    <div>
                        <label for="divisi" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Divisi <span class="text-rose-500">*</span></label>
                        <select id="divisi" name="divisi" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 text-xs transition-all outline-none appearance-none">
                            <option value="">Pilih Divisi</option>
                            <option value="recurve">Recurve</option>
                            <option value="compound">Compound</option>
                            <option value="standard">Standard Bow / Nasional</option>
                            <option value="barebow">Barebow</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="klub" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Klub Panahan</label>
                        <input type="text" id="klub" name="klub" placeholder="Contoh: X-Ten Archery" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none" />
                    </div>
                    <div>
                        <label for="kota" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kota Asal</label>
                        <input type="text" id="kota" name="kota" placeholder="Contoh: Jakarta" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-100 placeholder-slate-600 text-xs transition-all outline-none" />
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="flex-1 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-2xl font-bold text-xs transition-all shadow-md shadow-brand-600/10 active:scale-95 duration-200">
                        <i class='bx bx-save mr-1.5'></i>
                        <span>Simpan</span>
                    </button>
                    <button type="button" onclick="closeAthleteModal()" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 rounded-2xl font-bold text-xs transition-all active:scale-95 duration-200">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Athletes Cards List -->
<div class="space-y-3">
    <?php if (empty($anggota)): ?>
        <div class="bg-slate-800/20 border border-dashed border-slate-800 py-12 px-4 rounded-3xl text-center text-slate-500 text-xs select-none">
            <i class='bx bx-user-x text-4xl text-slate-750 mb-2 block'></i>
            <span>Belum ada data atlet terdaftar.<br>Klik tombol "Atlet Baru" untuk menambahkan.</span>
        </div>
    <?php else: ?>
        <?php foreach ($anggota as $person): ?>
            <div class="bg-slate-800/30 border border-slate-800/80 p-4 rounded-3xl hover:border-slate-700 transition-all flex flex-col justify-between relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 font-black text-sm shrink-0 shadow-sm">
                            <?= strtoupper(substr($person['nama'], 0, 2)) ?>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white"><?= esc($person['nama']) ?></h4>
                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1 text-[10px] text-slate-400 font-medium">
                                <?php if ($person['telepon']): ?>
                                    <span class="flex items-center gap-1"><i class='bx bx-phone text-xs text-brand-400/85'></i><?= esc($person['telepon']) ?></span>
                                <?php endif; ?>
                                <?php if ($person['email']): ?>
                                    <span class="flex items-center gap-1"><i class='bx bx-envelope text-xs text-brand-400/85'></i><?= esc($person['email']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($person['divisi'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-target-lock text-xs text-brand-400/85'></i>
                                        <span class="capitalize"><?= esc($person['divisi']) ?></span>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($person['klub'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-building-house text-xs text-brand-400/85'></i>
                                        <?= esc($person['klub']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($person['kota'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-map text-xs text-brand-400/85'></i>
                                        <?= esc($person['kota']) ?>
                                    </span>
                                <?php endif; ?>
                                <span class="flex items-center gap-1">
                                    <i class='bx bx-run text-xs text-brand-400/85'></i>
                                    <span class="font-bold text-slate-300"><?= esc($person['cabor'] ?? 'Panahan') ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Menu Options -->
                    <div class="flex items-center gap-1">
                        <button onclick="editAthlete(<?= htmlspecialchars(json_encode($person)) ?>)" class="w-7 h-7 rounded-lg bg-slate-800/50 hover:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition-all" title="Edit Profil">
                            <i class='bx bx-edit-alt text-base'></i>
                        </button>
                        <button onclick="confirmDelete(<?= $person['id'] ?>, '<?= esc($person['nama']) ?>')" class="w-7 h-7 rounded-lg bg-slate-850/50 hover:bg-rose-950/40 border border-slate-800/30 hover:border-rose-900/40 flex items-center justify-center text-slate-400 hover:text-rose-400 transition-all" title="Hapus Atlet">
                            <i class='bx bx-trash text-base'></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function openAthleteModal(mode, data = {}) {
        const modal = document.getElementById('athlete-form-modal');
        const title = document.getElementById('form-modal-title');
        const form = document.getElementById('athlete-form');
        
        // Reset form
        form.reset();
        
        if (mode === 'create') {
            title.textContent = 'Tambah Atlet Baru';
            form.action = '/anggota/store';
        } else if (mode === 'edit') {
            title.textContent = 'Ubah Data Atlet';
            form.action = `/anggota/update/${data.id}`;
            document.getElementById('nama').value = data.nama;
            document.getElementById('telepon').value = data.telepon || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('jenis_kelamin').value = data.jenis_kelamin || '';
            document.getElementById('divisi').value = data.divisi || '';
            document.getElementById('klub').value = data.klub || '';
            document.getElementById('kota').value = data.kota || '';
        }
        // Simply add class to keep modal open without shifting layout
        document.body.classList.add('modal-open');
        modal.classList.remove('hidden');
        document.getElementById('nama').focus({preventScroll:true});
    }

    function closeAthleteModal() {
        const modal = document.getElementById('athlete-form-modal');
        modal.classList.add('hidden');
        // Reset overflow and padding
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        document.body.classList.remove('modal-open');
    }

    function editAthlete(data) {
        openAthleteModal('edit', data);
    }

    function hideForm() {
        document.getElementById('athlete-form-panel').classList.add('hidden');
    }

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Atlet?',
            html: `Apakah Anda yakin ingin menghapus profil atlet <strong>${name}</strong>?<br><br><span class="text-rose-400 text-[10px] font-bold uppercase tracking-wider">Peringatan:</span> <span class="text-slate-400 text-xs">Semua riwayat scoring game atlet ini juga akan ikut terhapus secara permanen.</span>`,
            icon: 'warning',
            background: (document.body.classList.contains('light-mode') ? '#ffffff' : '#1e293b'),
            color: (document.body.classList.contains('light-mode') ? '#0f172a' : '#f8fafc'),
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // rose-600
            cancelButtonColor: '#475569',  // slate-600
            confirmButtonText: 'Ya, Hapus Permanen',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route
                window.location.href = `/anggota/delete/${id}`;
            }
        });
    }
</script>

<?= $this->endSection() ?>
