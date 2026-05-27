<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Athlete Sesi Header Card -->
<div class="mb-5 bg-slate-800/20 border border-slate-800 p-4 rounded-3xl flex justify-between items-center select-none shadow shadow-black/10">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0">
            <i class='bx bx-spreadsheet text-xl'></i>
        </div>
        <div>
            <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                <?= $game['tipe_game'] === 'aduan' ? 'Duel Set' : 'Sesi ' . $sessionNumber ?>
            </h3>
            <span class="text-[9px] text-slate-400 font-bold block mt-0.5">
                <?= esc($game['nama_anggota']) ?> 
                <?= $game['tipe_game'] === 'aduan' ? '<span class="text-amber-400 font-black">VS</span> ' . esc($namaLawan) : '' ?>
            </span>
        </div>
    </div>
    
    <div class="flex items-center gap-2 shrink-0">
        <button onclick="saveAllShoots(false)" class="px-3 py-2 bg-slate-800 hover:bg-slate-750 text-slate-300 border border-slate-700 rounded-2xl transition-all text-xs font-bold flex items-center gap-1.5 active:scale-95 duration-200">
            <i class='bx bx-save text-base text-brand-400'></i>
            <span>Simpan</span>
        </button>
        <button onclick="saveAllShoots(true)" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl transition-all text-xs font-bold flex items-center gap-1.5 shadow-md shadow-emerald-600/10 active:scale-95 duration-200">
            <i class='bx bx-check-double text-base'></i>
            <span>Selesai</span>
        </button>
    </div>
</div>

<!-- Running Poin Set or Score Display (Only for Aduan) -->
<?php if ($game['tipe_game'] === 'aduan'): ?>
    <div class="mb-4 py-2.5 px-4 bg-slate-950/60 border border-slate-800/80 rounded-2xl flex justify-between items-center select-none">
        <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest text-slate-400" id="running-score-label">
            <?= $game['divisi'] === 'compound' ? 'Running Scores' : 'Running Set Points' ?>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-white"><?= esc(explode(' ', $game['nama_anggota'])[0]) ?></span>
            <span class="px-2.5 py-0.5 bg-brand-500/20 text-brand-400 border border-brand-500/30 rounded-lg text-sm font-black" id="live-set-atlet">0</span>
            <span class="text-slate-600 text-xs font-black">:</span>
            <span class="px-2.5 py-0.5 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-lg text-sm font-black" id="live-set-lawan">0</span>
            <span class="text-xs font-bold text-white"><?= esc(explode(' ', $namaLawan)[0]) ?></span>
        </div>
    </div>
<?php endif; ?>

<!-- Interactive Scoring Grid -->
<div class="bg-slate-850 border border-slate-800/90 rounded-3xl overflow-hidden shadow-lg shadow-black/25 pb-4">
    <div class="overflow-x-auto no-scrollbar">
        <?php if ($game['tipe_game'] === 'aduan' || $game['tipe_game'] === 'mixteam'): ?>
            <?php 
                $numArrows = ($game['tipe_game'] === 'mixteam') ? 4 : 3; 
            ?>
            <!-- Aduan / Mix Team Duel Layout -->
            <table class="w-full select-none table-fixed min-w-full">
                <thead class="bg-slate-900/60 border-b border-slate-800/80">
                    <tr>
                        <th class="w-6 min-[380px]:w-8 py-3 text-center text-[9px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-800/30">Set</th>
                        <th colspan="<?= $numArrows ?>" class="py-3 text-center text-[9px] font-black text-brand-400 uppercase tracking-widest">
                            <?= esc(explode(' ', $game['nama_anggota'])[0]) ?>
                            <?= $game['tipe_game'] === 'mixteam' ? ' & ' . esc(explode(' ', $game['partner_nama'])[0]) : '' ?>
                        </th>
                        <th class="w-6 min-[380px]:w-8 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Tot</th>
                        <th class="w-8 min-[380px]:w-10 py-3 text-center text-[8px] font-black text-amber-500 uppercase tracking-widest" id="poin-header-title">
                            <?= ($game['divisi'] === 'compound' || $game['divisi'] === 'barebow') ? 'Lead' : 'Poin' ?>
                        </th>
                        <th class="w-6 min-[380px]:w-8 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Tot</th>
                        <th colspan="<?= $numArrows ?>" class="py-3 text-center pr-2 min-[380px]:pr-4 text-[9px] font-black text-amber-400 uppercase tracking-widest"><?= esc(explode(' ', $namaLawan)[0]) ?></th>
                    </tr>
                </thead>
                <tbody id="shootsTableBody" class="divide-y divide-slate-800/40">
                    <!-- Duel Rows injected via JS -->
                </tbody>
                <tfoot class="bg-slate-900/70 border-t border-slate-800">
                    <tr>
                        <td colspan="<?= $numArrows + 1 ?>" class="px-3 pt-3.5 pb-6 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Skor Akumulatif</td>
                        <td class="pt-3.5 pb-6 text-center text-xs font-black text-brand-400" id="totalScoreAtlet">0</td>
                        <td class="pt-3.5 pb-6 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest border-x border-slate-800">Skor Akhir</td>
                        <td class="pt-3.5 pb-6 text-center text-xs font-black text-amber-400" id="totalScoreLawan">0</td>
                        <td colspan="<?= $numArrows ?>" class="pt-3.5 pb-6"></td>
                    </tr>
                </tfoot>
            </table>

        <?php else: ?>
            <!-- Standard Qualification Layout -->
            <table class="w-full select-none table-fixed min-w-full">
                <thead class="bg-slate-900/60 border-b border-slate-800/80">
                    <tr>
                        <th class="w-8 min-[380px]:w-12 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Rbh</th>
                        <th colspan="6" class="py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Nilai Anak Panah</th>
                        <th class="w-10 min-[380px]:w-14 py-3 text-center pr-2 min-[380px]:pr-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tot</th>
                    </tr>
                </thead>
                <tbody id="shootsTableBody" class="divide-y divide-slate-800/40">
                    <!-- Standard Rows injected via JS -->
                </tbody>
                <tfoot class="bg-slate-900/70 border-t border-slate-800">
                    <tr>
                        <td colspan="7" class="px-5 pt-4 pb-6 text-left text-xs font-extrabold text-slate-400 uppercase tracking-widest">Grand Total Sesi</td>
                        <td class="pt-4 pb-6 pr-2 min-[380px]:pr-4 text-center text-base font-black text-emerald-400" id="grandTotal">0</td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Bottom Modal/Sheet: Target Colored Score Picker -->
<div id="scorePickerModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-end justify-center transition-all duration-300" onclick="closeScorePickerOnBackdrop(event)">
    
    <div class="bg-slate-900 border-t border-slate-800 rounded-t-[32px] w-full max-w-md p-5 pb-8 shadow-2xl relative translate-y-0 transition-transform duration-300 select-none md:rounded-b-[36px] md:border-b md:border-slate-800">
        
        <div class="w-10 h-1 bg-slate-700 rounded-full mx-auto mb-4"></div>
        
        <div class="flex justify-between items-center mb-3">
            <div>
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Masukkan Skor</h3>
                <p id="scorePickerLabel" class="text-sm font-bold text-white mt-0.5">Rambahan 1 - Anak Panah 1</p>
            </div>
            <button onclick="closeScorePicker()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-750 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>

        <!-- Target face style selector keypad -->
        <div class="grid grid-cols-3 gap-2.5 mt-4">
            
            <!-- YELLOW (10/9s) -->
            <button onclick="selectScoreFromPicker('X', 10)" class="aspect-square bg-gradient-to-br from-amber-300 to-amber-500 active:scale-95 text-slate-950 font-black text-2xl rounded-2xl border border-amber-300/40 transition-all flex items-center justify-center">X</button>
            <button onclick="selectScoreFromPicker('10', 10)" class="aspect-square bg-gradient-to-br from-amber-300 to-amber-500 active:scale-95 text-slate-950 font-black text-2xl rounded-2xl border border-amber-300/40 transition-all flex items-center justify-center">10</button>
            <button onclick="selectScoreFromPicker('9', 9)" class="aspect-square bg-gradient-to-br from-amber-300 to-amber-500 active:scale-95 text-slate-950 font-black text-2xl rounded-2xl border border-amber-300/40 transition-all flex items-center justify-center">9</button>

            <!-- RED (8/7s) -->
            <button onclick="selectScoreFromPicker('8', 8)" class="aspect-square bg-gradient-to-br from-rose-500 to-rose-600 active:scale-95 text-white font-black text-2xl rounded-2xl border border-rose-500/40 transition-all flex items-center justify-center">8</button>
            <button onclick="selectScoreFromPicker('7', 7)" class="aspect-square bg-gradient-to-br from-rose-500 to-rose-600 active:scale-95 text-white font-black text-2xl rounded-2xl border border-rose-500/40 transition-all flex items-center justify-center">7</button>

            <!-- BLUE (6/5s) -->
            <button onclick="selectScoreFromPicker('6', 6)" class="aspect-square bg-gradient-to-br from-sky-500 to-sky-600 active:scale-95 text-white font-black text-2xl rounded-2xl border border-sky-500/40 transition-all flex items-center justify-center">6</button>
            <button onclick="selectScoreFromPicker('5', 5)" class="aspect-square bg-gradient-to-br from-sky-500 to-sky-600 active:scale-95 text-white font-black text-2xl rounded-2xl border border-sky-500/40 transition-all flex items-center justify-center">5</button>

            <!-- BLACK (4/3s) -->
            <button onclick="selectScoreFromPicker('4', 4)" style="color: #ffffff !important;" class="aspect-square bg-black active:scale-95 !text-white font-black text-2xl rounded-2xl border border-slate-800 transition-all flex items-center justify-center shadow">4</button>
            <button onclick="selectScoreFromPicker('3', 3)" style="color: #ffffff !important;" class="aspect-square bg-black active:scale-95 !text-white font-black text-2xl rounded-2xl border border-slate-800 transition-all flex items-center justify-center shadow">3</button>

            <!-- WHITE (2/1/0s) -->
            <button onclick="selectScoreFromPicker('2', 2)" class="aspect-square bg-white active:scale-95 text-slate-900 font-black text-2xl rounded-2xl border border-slate-300 transition-all flex items-center justify-center shadow">2</button>
            <button onclick="selectScoreFromPicker('1', 1)" class="aspect-square bg-white active:scale-95 text-slate-900 font-black text-2xl rounded-2xl border border-slate-300 transition-all flex items-center justify-center shadow">1</button>
            <button onclick="selectScoreFromPicker('M', 0)" class="aspect-square bg-white active:scale-95 text-slate-900 font-black text-2xl rounded-2xl border border-slate-300 transition-all flex items-center justify-center shadow">M</button>
        </div>
    </div>
</div>

<script>
    // Embedded Database Data
    var game = <?= json_encode($game) ?>;
    var sessionNumber = <?= $sessionNumber ?>;
    var shootTotals = <?= json_encode($shootTotals) ?>;
    var shootData = <?= json_encode($shootData) ?>;

    var scoreOptions = {
        'X': 10, '10': 10, '9': 9, '8': 8, '7': 7, '6': 6, '5': 5, '4': 4, '3': 3, '2': 2, '1': 1, 'M': 0, '-': 0
    };

    function getScoreClass(score, display) {
        let s = parseInt(score);
        
        if (display === '-') {
            return 'bg-slate-900/60 text-slate-600 border-slate-800/80';
        }

        if (display === 'X' || s === 10 || s === 9) {
            return 'bg-amber-400 text-slate-900 border-amber-500 shadow shadow-amber-500/5';
        } else if (s === 8 || s === 7) {
            return 'bg-rose-500 !text-white border-rose-600 shadow shadow-rose-600/5';
        } else if (s === 6 || s === 5) {
            return 'bg-sky-500 !text-white border-sky-600 shadow shadow-sky-600/5';
        } else if (s === 4 || s === 3) {
            return 'bg-black !text-white border-slate-800 shadow shadow-black/10';
        } else if (s <= 2 || display === 'M' || display === '0') {
            return 'bg-white text-slate-900 border-slate-200 shadow shadow-white/5';
        }
        return 'bg-slate-900/60 text-slate-600 border-slate-800/80';
    }

    // Active Pointer variables
    var currentShoot = null;
    var currentArrow = null;
    var currentIsLawan = 0; // 0 = atlet utama, 1 = lawan

    // Dynamic grid loading
    function loadGrid() {
        const tbody = document.getElementById("shootsTableBody");
        let html = '';

        if (game.tipe_game === 'aduan' || game.tipe_game === 'mixteam') {
            const numSets = (game.tipe_game === 'mixteam') ? 4 : 5;
            const numArrows = (game.tipe_game === 'mixteam') ? 4 : 3;

            // Render Sets for Aduan/Mixteam
            for (let setNum = 1; setNum <= numSets; setNum++) {
                const atletShots = (shootData[setNum] && shootData[setNum][0]) ? shootData[setNum][0] : [];
                const lawanShots = (shootData[setNum] && shootData[setNum][1]) ? shootData[setNum][1] : [];

                const atletData = [];
                const lawanData = [];

                for (let arrow = 1; arrow <= numArrows; arrow++) {
                    const aInfo = atletShots.find(s => s.arrow_number === arrow);
                    const lInfo = lawanShots.find(s => s.arrow_number === arrow);

                    atletData.push(aInfo ? { score: aInfo.score, display: aInfo.display_value } : { score: 0, display: '-' });
                    lawanData.push(lInfo ? { score: lInfo.score, display: lInfo.display_value } : { score: 0, display: '-' });
                }

                const atletTotal = atletData.reduce((sum, a) => sum + a.score, 0);
                const lawanTotal = lawanData.reduce((sum, a) => sum + a.score, 0);

                html += `
                    <tr class="hover:bg-slate-900/10 transition-colors" data-shoot="${setNum}">
                        <!-- Set Number -->
                        <td class="py-3 text-center text-xs font-bold text-slate-500 border-r border-slate-800/40">${setNum}</td>
                        
                        <!-- Atlet Buttons -->
                        ${atletData.map((arrow, idx) => {
                            const arrowNum = idx + 1;
                            return `
                                <td class="py-2 text-center px-0 min-[380px]:px-0.5">
                                    <button type="button" 
                                        data-shoot="${setNum}" 
                                        data-arrow="${arrowNum}"
                                        data-lawan="0"
                                        onclick="openScorePicker(${setNum}, ${arrowNum}, 0, ${arrow.score}, '${arrow.display}')"
                                        class="w-6 h-6 min-[380px]:w-7 min-[380px]:h-7 md:w-8 md:h-8 rounded-full font-black text-[10px] min-[380px]:text-xs md:text-sm border min-[380px]:border-2 text-center transition-all active:scale-90 mx-auto ${getScoreClass(arrow.score, arrow.display)}">
                                        ${arrow.display}
                                    </button>
                                </td>
                            `;
                        }).join('')}
                        
                        <!-- Atlet Total Set Score -->
                        <td class="py-3 text-center text-xs font-black text-brand-400 border-l border-slate-800/20" id="atlet-total-${setNum}">${atletTotal}</td>
                        
                        <!-- Set points indicator (Real-time in middle column) -->
                        <td class="py-3 text-center text-[10px] font-black text-slate-400 border-x border-slate-800/40 bg-slate-900/20" id="set-poin-${setNum}">0 - 0</td>
                        
                        <!-- Lawan Total Set Score -->
                        <td class="py-3 text-center text-xs font-black text-amber-400 border-r border-slate-800/20" id="lawan-total-${setNum}">${lawanTotal}</td>

                        <!-- Lawan Buttons -->
                        ${lawanData.map((arrow, idx) => {
                            const arrowNum = idx + 1;
                            const isLast = idx === lawanData.length - 1;
                            return `
                                <td class="py-2 text-center ${isLast ? 'pl-0 min-[380px]:pl-0.5 pr-2 min-[380px]:pr-4' : 'px-0 min-[380px]:px-0.5'}">
                                    <button type="button" 
                                        data-shoot="${setNum}" 
                                        data-arrow="${arrowNum}"
                                        data-lawan="1"
                                        onclick="openScorePicker(${setNum}, ${arrowNum}, 1, ${arrow.score}, '${arrow.display}')"
                                        class="w-6 h-6 min-[380px]:w-7 min-[380px]:h-7 md:w-8 md:h-8 rounded-full font-black text-[10px] min-[380px]:text-xs md:text-sm border min-[380px]:border-2 text-center transition-all active:scale-90 mx-auto ${getScoreClass(arrow.score, arrow.display)}">
                                        ${arrow.display}
                                    </button>
                                </td>
                            `;
                        }).join('')}
                    </tr>
                `;
            }
            tbody.innerHTML = html;
            updateAduanTotals();

        } else {
            // Render 6 Shoots * 6 Arrows for standard qualification
            for (let shootNum = 1; shootNum <= 6; shootNum++) {
                const arrows = (shootData[shootNum] && shootData[shootNum][0]) ? shootData[shootNum][0] : [];
                
                const arrowData = [];
                for (let arrow = 1; arrow <= 6; arrow++) {
                    const arrowInfo = arrows.find(a => a.arrow_number === arrow);
                    arrowData.push(arrowInfo ? { score: arrowInfo.score, display: arrowInfo.display_value } : { score: 0, display: '-' });
                }

                const total = arrowData.reduce((sum, a) => sum + a.score, 0);

                html += `
                    <tr class="hover:bg-slate-900/20 transition-colors" data-shoot="${shootNum}">
                        <td class="py-3 text-center text-xs font-bold text-slate-500 border-r border-slate-800/40">${shootNum}</td>
                        ${arrowData.map((arrow, idx) => {
                            const arrowNum = idx + 1;
                            const isLast = idx === arrowData.length - 1;
                            return `
                                <td class="py-2 text-center ${isLast ? 'pl-0 min-[380px]:pl-0.5 pr-2 min-[380px]:pr-4' : 'px-0 min-[380px]:px-0.5'}">
                                    <button type="button" 
                                        data-shoot="${shootNum}" 
                                        data-arrow="${arrowNum}"
                                        data-lawan="0"
                                        onclick="openScorePicker(${shootNum}, ${arrowNum}, 0, ${arrow.score}, '${arrow.display}')"
                                        class="w-7 h-7 min-[380px]:w-8 min-[380px]:h-8 md:w-10 md:h-10 rounded-full font-black text-xs min-[380px]:text-sm border-2 text-center transition-all active:scale-90 mx-auto ${getScoreClass(arrow.score, arrow.display)}">
                                        ${arrow.display}
                                    </button>
                                </td>
                            `;
                        }).join('')}
                        <td class="py-3 text-center text-sm font-black text-slate-300 border-l border-slate-800/40 pr-2 min-[380px]:pr-4" id="total-${shootNum}">${total}</td>
                    </tr>
                `;
            }
            tbody.innerHTML = html;
            updateGrandTotal();
        }
    }

    var activeButton = null;

    function openScorePicker(shootNum, arrowNum, isLawan, score, display) {
        // Clear any existing active highlight ring
        if (activeButton) {
            activeButton.classList.remove('ring-4', 'ring-brand-500/50', 'scale-110');
        }

        currentShoot = shootNum;
        currentArrow = arrowNum;
        currentIsLawan = isLawan;

        // Find and highlight current clicked button
        const row = document.querySelector(`tr[data-shoot="${shootNum}"]`);
        activeButton = row.querySelector(`button[data-arrow="${arrowNum}"][data-lawan="${isLawan}"]`);
        if (activeButton) {
            activeButton.classList.add('ring-4', 'ring-brand-500/50', 'scale-110');
        }

        const modal = document.getElementById('scorePickerModal');
        const label = document.getElementById('scorePickerLabel');
        
        const ownerName = isLawan === 1 ? 'Lawan' : 'Atlet Utama';
        label.textContent = `${ownerName} | Set ${shootNum} - Panah ${arrowNum}`;
        modal.classList.remove('hidden');
    }

    function closeScorePicker() {
        document.getElementById('scorePickerModal').classList.add('hidden');
        if (activeButton) {
            activeButton.classList.remove('ring-4', 'ring-brand-500/50', 'scale-110');
            activeButton = null;
        }
        currentShoot = null;
        currentArrow = null;
    }

    function closeScorePickerOnBackdrop(event) {
        if (event.target.id === 'scorePickerModal') {
            closeScorePicker();
        }
    }

    // Select Score & Close Keypad (Manual selection to avoid accidental clicks)
    function selectScoreFromPicker(value, score) {
        if (currentShoot === null || currentArrow === null) return;

        const row = document.querySelector(`tr[data-shoot="${currentShoot}"]`);
        const button = row.querySelector(`button[data-arrow="${currentArrow}"][data-lawan="${currentIsLawan}"]`);
        
        button.textContent = value;
        button.className = button.className.split(' ').filter(c => 
            !c.startsWith('bg-') && !c.startsWith('text-') && !c.startsWith('border-') && !c.startsWith('shadow')
        ).join(' ');
        button.className += ` ${getScoreClass(score, value)}`;

        // Recalculate Row Totals
        if (game.tipe_game === 'aduan' || game.tipe_game === 'mixteam') {
            // Recalculate Athlete or Opponent set total
            let setTotal = 0;
            const targetArrowCount = (game.tipe_game === 'mixteam') ? 4 : 3;
            for (let i = 1; i <= targetArrowCount; i++) {
                const btn = row.querySelector(`button[data-arrow="${i}"][data-lawan="${currentIsLawan}"]`);
                setTotal += scoreOptions[btn.textContent.trim()] || 0;
            }

            const prefix = currentIsLawan === 1 ? 'lawan' : 'atlet';
            document.getElementById(`${prefix}-total-${currentShoot}`).textContent = setTotal;
            
            // Recalculate set points & cumulative score totals
            updateAduanTotals();
        } else {
            // Qualification: recalculate row total (6 arrows)
            let rowTotal = 0;
            for (let i = 1; i <= 6; i++) {
                const btn = row.querySelector(`button[data-arrow="${i}"][data-lawan="0"]`);
                rowTotal += scoreOptions[btn.textContent.trim()] || 0;
            }
            document.getElementById(`total-${currentShoot}`).textContent = rowTotal;
            updateGrandTotal();
        }

        // Close score picker keypad immediately
        closeScorePicker();
    }

    // Dynamic set point calculations and summary updates for Aduan (Duel)
    function updateAduanTotals() {
        let cumulativeScoreAtlet = 0;
        let cumulativeScoreLawan = 0;
        
        let cumulativeSetAtlet = 0;
        let cumulativeSetLawan = 0;

        const isCompound = (game.divisi === 'compound' || game.divisi === 'barebow');

        const numSets = (game.tipe_game === 'mixteam') ? 4 : 5;
        const numArrows = (game.tipe_game === 'mixteam') ? 4 : 3;

        for (let s = 1; s <= numSets; s++) {
            const atletVal = document.getElementById(`atlet-total-${s}`).textContent.trim();
            const lawanVal = document.getElementById(`lawan-total-${s}`).textContent.trim();
            
            const aScore = parseInt(atletVal) || 0;
            const lScore = parseInt(lawanVal) || 0;

            // Collect scores regardless of set status for overall sum
            cumulativeScoreAtlet += aScore;
            cumulativeScoreLawan += lScore;

            // Check if both sides have arrows fully shot in this set (no empty '-' value)
            const row = document.querySelector(`tr[data-shoot="${s}"]`);
            let isSetComplete = true;
            
            for (let arrow = 1; arrow <= numArrows; arrow++) {
                const btnA = row.querySelector(`button[data-arrow="${arrow}"][data-lawan="0"]`);
                const btnL = row.querySelector(`button[data-arrow="${arrow}"][data-lawan="1"]`);
                if (btnA.textContent.trim() === '-' || btnL.textContent.trim() === '-') {
                    isSetComplete = false;
                    break;
                }
            }

            const indicator = document.getElementById(`set-poin-${s}`);
            if (isSetComplete) {
                if (isCompound) {
                    // Compound shows cumulative difference (lead) up to this set
                    const diff = cumulativeScoreAtlet - cumulativeScoreLawan;
                    if (diff > 0) {
                        indicator.textContent = `+${diff}`;
                        indicator.className = "py-3 text-center text-xs font-black text-emerald-400 border-x border-slate-800/40 bg-emerald-500/5";
                    } else if (diff === 0) {
                        indicator.textContent = "=";
                        indicator.className = "py-3 text-center text-xs font-black text-slate-400 border-x border-slate-800/40 bg-slate-900/20";
                    } else {
                        indicator.textContent = `${diff}`;
                        indicator.className = "py-3 text-center text-xs font-black text-rose-400 border-x border-slate-800/40 bg-rose-500/5";
                    }
                } else {
                    // Recurve/Nasional uses Set Points
                    if (aScore > lScore) {
                        indicator.textContent = "2 - 0";
                        indicator.className = "py-3 text-center text-xs font-black text-emerald-400 border-x border-slate-800/40 bg-emerald-500/5";
                        cumulativeSetAtlet += 2;
                    } else if (aScore === lScore) {
                        indicator.textContent = "1 - 1";
                        indicator.className = "py-3 text-center text-xs font-black text-slate-400 border-x border-slate-800/40 bg-slate-900/20";
                        cumulativeSetAtlet += 1;
                        cumulativeSetLawan += 1;
                    } else {
                        indicator.textContent = "0 - 2";
                        indicator.className = "py-3 text-center text-xs font-black text-rose-400 border-x border-slate-800/40 bg-rose-500/5";
                        cumulativeSetLawan += 2;
                    }
                }
            } else {
                indicator.textContent = "-";
                indicator.className = "py-3 text-center text-xs font-black text-slate-600 border-x border-slate-800/40 bg-slate-900/10";
            }
        }

        // Update live score displays
        document.getElementById('totalScoreAtlet').textContent = cumulativeScoreAtlet;
        document.getElementById('totalScoreLawan').textContent = cumulativeScoreLawan;
        
        const liveAtlet = document.getElementById('live-set-atlet');
        const liveLawan = document.getElementById('live-set-lawan');
        
        if (isCompound) {
            if (liveAtlet) liveAtlet.textContent = cumulativeScoreAtlet;
            if (liveLawan) liveLawan.textContent = cumulativeScoreLawan;
        } else {
            if (liveAtlet) liveAtlet.textContent = cumulativeSetAtlet;
            if (liveLawan) liveLawan.textContent = cumulativeSetLawan;
        }
    }

    // Standard Grand total counter for qualification
    function updateGrandTotal() {
        let grandTotal = 0;
        for (let s = 1; s <= 6; s++) {
            const totalEl = document.getElementById(`total-${s}`);
            if (totalEl) grandTotal += parseInt(totalEl.textContent) || 0;
        }
        document.getElementById('grandTotal').textContent = grandTotal;
    }

    // Unified Save scoring sheet handler
    async function saveAllShoots(shouldRedirect = true) {
        const isAduan = (game.tipe_game === 'aduan');
        const isMixteam = (game.tipe_game === 'mixteam');
        
        const targetShootCount = isMixteam ? 4 : (isAduan ? 5 : 6);
        const targetArrowCount = isMixteam ? 4 : (isAduan ? 3 : 6);
        
        const sessionsData = [];
        let hasEmpty = false;

        for (let s = 1; s <= targetShootCount; s++) {
            const row = document.querySelector(`tr[data-shoot="${s}"]`);
            
            const athleteArrows = [];
            const opponentArrows = [];

            // 1. Collect Athlete Arrows
            for (let a = 1; a <= targetArrowCount; a++) {
                const btn = row.querySelector(`button[data-arrow="${a}"][data-lawan="0"]`);
                const val = btn.textContent.trim();
                if (val === '-') {
                    hasEmpty = true;
                    athleteArrows.push({ arrow_number: a, score: 0, display_value: '-' });
                } else {
                    athleteArrows.push({ arrow_number: a, score: scoreOptions[val], display_value: val });
                }
            }

            // 2. Collect Opponent Arrows (Only for Aduan/Mix Team)
            if (isAduan || isMixteam) {
                for (let a = 1; a <= targetArrowCount; a++) {
                    const btn = row.querySelector(`button[data-arrow="${a}"][data-lawan="1"]`);
                    const val = btn.textContent.trim();
                    if (val === '-') {
                        hasEmpty = true;
                        opponentArrows.push({ arrow_number: a, score: 0, display_value: '-' });
                    } else {
                        opponentArrows.push({ arrow_number: a, score: scoreOptions[val], display_value: val });
                    }
                }
            }

            sessionsData.push({
                shoot_number: s,
                athlete_arrows: athleteArrows,
                opponent_arrows: (isAduan || isMixteam) ? opponentArrows : null
            });
        }

        // Warn if empty
        if (hasEmpty) {
            const warnRes = await Swal.fire({
                title: 'Data Masih Kosong!',
                html: 'Beberapa anak panah terdeteksi belum diisi skornya.<br><br>Apakah Anda tetap ingin menyimpan lembar scoring ini?',
                icon: 'warning',
                background: '#1e293b',
                color: '#f8fafc',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tetap Simpan',
                cancelButtonText: 'Batal'
            });
            if (!warnRes.isConfirmed) return;
        } else {
            const confirmRes = await Swal.fire({
                title: shouldRedirect ? 'Simpan & Selesai?' : 'Simpan Sementara?',
                text: shouldRedirect 
                    ? 'Semua skor akan disimpan dan Anda akan dialihkan ke halaman detail.' 
                    : 'Skor akan disimpan di database tanpa meninggalkan halaman ini.',
                icon: 'question',
                background: '#1e293b',
                color: '#f8fafc',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            });
            if (!confirmRes.isConfirmed) return;
        }

        // Show custom transparent sports loader
        showLoading('MENYIMPAN SKOR', 'Memproses perhitungan total skor...');

        try {
            // Save each shoot/set sequentially to prevent SQLite database locking on concurrent production servers
            const baseUrl = window.location.href.split('/sesi')[0];
            const results = [];
            
            for (const setInfo of sessionsData) {
                const response = await fetch(`${baseUrl}/shoot`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        session_number: sessionNumber,
                        shoot_number: setInfo.shoot_number,
                        athlete_arrows: setInfo.athlete_arrows,
                        opponent_arrows: setInfo.opponent_arrows
                    })
                });
                const result = await response.json();
                results.push(result);
            }
            const failed = results.filter(r => !r.success);

            hideLoading();
            Swal.close();

            if (failed.length === 0) {
                if (shouldRedirect) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Scoring Selesai!',
                        text: 'Semua skor telah disimpan permanen.',
                        background: '#1e293b',
                        color: '#f8fafc',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = window.location.href.split('/sesi')[0];
                    });
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        icon: 'success',
                        title: 'Skor disimpan sementara!',
                        background: '#1e293b',
                        color: '#f8fafc',
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: failed[0].message || 'Gagal menyimpan lembar scoring.',
                    background: '#1e293b',
                    color: '#f8fafc',
                    confirmButtonColor: '#8b5cf6'
                });
            }

        } catch (error) {
            hideLoading();
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Kegagalan Jaringan',
                text: 'Sistem gagal menghubungi server. Periksa koneksi Anda.',
                background: '#1e293b',
                color: '#f8fafc',
                confirmButtonColor: '#8b5cf6'
            });
        }
    }

    // Trigger Initial load
    loadGrid();
</script>

<?= $this->endSection() ?>
