<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <script>
        // Apply saved theme immediately to prevent flash of wrong theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.remove('light-mode');
        } else {
            document.documentElement.classList.add('light-mode');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Scoring App' ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="manifest" href="/manifest.json">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js').catch(function (err) {
                    console.error('ServiceWorker registration failed:', err);
                });
            });
        }
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Boxicons (elegan & modern) -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Immediately check and apply the saved theme before HTML parses to prevent theme flashes -->
    <script>
        // Ensure a theme is set; default to light mode
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'light');
        }
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light-mode');
        }
    </script>
    <style>
        /* Hide default scrollbar but allow scrolling */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* DYNAMIC CONFIGURABLE THEME COLORS */
        :root {
            /* Default Dark Mode (Premium Slate Blue) */
            --bg-body: #090d16;
            --bg-frame: #0f172a;
            --bg-viewport: linear-gradient(180deg, #0f172a 0%, #0f172a 50%, #020617 100%);
            --bg-header: rgba(15, 23, 42, 0.9);
            --bg-nav: rgba(2, 6, 23, 0.95);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-header: rgba(255, 255, 255, 0.08);
            --border-nav: rgba(255, 255, 255, 0.05);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --bg-card: rgba(30, 41, 59, 0.35);
            --bg-card-hover: rgba(30, 41, 59, 0.55);
            --border-card: rgba(255, 255, 255, 0.08);
            --border-card-hover: rgba(255, 255, 255, 0.15);
            --bg-input: #090d16;
            --text-input: #f8fafc;
            --bg-icon-box: rgba(30, 41, 59, 0.6);
        }

        .light-mode {
    /* Light Mode (Premium Ice Blue & Clean Slate) */
    --bg-body: #fafafa;
    --bg-frame: #ffffff;
    --bg-viewport: linear-gradient(180deg, #ffffff 0%, #f8fafc 55%, #fafafa 100%);
    --bg-header: rgba(255, 255, 255, 0.96);
    --bg-nav: rgba(255, 255, 255, 0.98);
    --border-color: rgba(15, 23, 42, 0.08);
    --border-header: rgba(15, 23, 42, 0.06);
    --border-nav: rgba(15, 23, 42, 0.05);
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-muted: #64748b;
    --bg-card: #ffffff;
    --bg-card-hover: #f8fafc;
    --border-card: rgba(15, 23, 42, 0.1);
    --border-card-hover: rgba(15, 23, 42, 0.2);
    --bg-input: #ffffff;
    --text-input: #0f172a;
    --bg-icon-box: rgba(226, 232, 240, 0.6);
}


        html { overflow-y: scroll; scrollbar-gutter: stable; }
        body { font-family: 'Outfit', 'Inter', sans-serif; background-color: var(--bg-body) !important; color: var(--text-primary) !important; overflow-x: hidden; overflow-y: scroll; height: 100%; margin: 0; /* Keep vertical scrollbar and prevent layout shift */ scrollbar-gutter: stable; transition: background-color 0.25s ease !important; }

        /* Prevent SweetAlert2 from breaking layout height and shifting footer */
        html.swal2-height-auto, body.swal2-height-auto,
        html.swal2-shown, body.swal2-shown {
            height: 100% !important;
        }

        /* Mobile viewport frame simulation for desktop */
        .modal-open { /* placeholder – JS handles padding */ }
        .modal-open .mobile-frame { overflow: hidden !important; }
        
        
        .mobile-frame {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            border-left: 1px solid var(--border-color) !important;
            border-right: 1px solid var(--border-color) !important;
            
            /* CRITICAL: Pure CSS layout to prevent stretching/FOUC before Tailwind loads */
            width: 100% !important;
            max-width: 448px !important; /* equivalent to max-w-md */
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            overflow-y: scroll !important;
            scrollbar-gutter: stable !important;
            position: relative !important;
            background-color: var(--bg-frame) !important;
            margin: 0 auto !important;
            transition: background-color 0.25s ease, border-color 0.25s ease !important;
        }
        @media (min-width: 768px) {
            .mobile-frame {
                height: 840px !important;
                border-radius: 36px !important;
            }
        }

        /* Content Area Dynamic Styling */
        .flex-1.overflow-y-auto, .flex-1.overflow-y-scroll {
            background: var(--bg-viewport) !important;
            transition: background 0.25s ease !important;
        }

        /* Header Overrides */
        .mobile-frame > div:first-child, .mobile-frame .sticky {
            background-color: var(--bg-header) !important;
            border-color: var(--border-header) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease !important;
        }

        /* Bottom Nav Overrides */
        .mobile-frame > div:nth-last-child(2), .absolute.bottom-0 {
            background-color: var(--bg-nav) !important;
            border-color: var(--border-nav) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease !important;
        }

        /* Premium Loader Styles - Pure CSS to prevent FOUC & Layout Shifts */
        .premium-loader {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            z-index: 9999 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: var(--bg-frame) !important;
            user-select: none !important;
            -webkit-user-select: none !important;
            transition: opacity 0.3s ease !important;
            opacity: 1 !important;
        }
        .premium-loader.hidden {
            display: none !important;
            opacity: 0 !important;
        }

        .premium-loader-spinner-container {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 96px !important;
            height: 96px !important;
        }

        .premium-loader-outer-ring {
            width: 80px !important;
            height: 80px !important;
            border-radius: 50% !important;
            border: 4px dashed #8b5cf6 !important; /* brand-500 */
            animation: premium-spin 2s linear infinite !important;
        }

        .premium-loader-middle-ring {
            position: absolute !important;
            width: 56px !important;
            height: 56px !important;
            border-radius: 50% !important;
            border: 4px solid #f43f5e !important; /* rose-500 */
            animation: premium-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite !important;
            opacity: 0.75 !important;
        }

        .premium-loader-center {
            position: absolute !important;
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #fcd34d, #f59e0b) !important; /* amber-300 to amber-500 */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.4) !important;
        }

        .premium-loader-center i {
            color: #0f172a !important;
            font-size: 20px !important;
            animation: premium-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite !important;
        }

        .premium-loader-title {
            color: var(--text-primary) !important;
            font-weight: 900 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            margin-top: 24px !important;
            text-align: center !important;
            font-family: 'Outfit', 'Inter', sans-serif !important;
        }

        .premium-loader-subtitle {
            color: var(--text-secondary) !important;
            font-size: 9px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            margin-top: 6px !important;
            text-align: center !important;
            font-family: 'Outfit', 'Inter', sans-serif !important;
        }

        /* ----------------------------------------------------
           DYNAMIC LIGHT MODE CSS OVERRIDES FOR TAILWIND STYLES 
           ---------------------------------------------------- */
        /* ----------------------------------------------------
           DYNAMIC LIGHT MODE CSS OVERRIDES FOR TAILWIND STYLES 
           ---------------------------------------------------- */
        .light-mode h1, 
        .light-mode h2, 
        .light-mode h3, 
        .light-mode h4,
        .light-mode p,
        .light-mode span,
        .light-mode a,
        .light-mode i,
        .light-mode label,
        .light-mode th,
        .light-mode td {
            transition: color 0.25s ease !important;
        }

        /* Comprehensive Text Color Overrides for Light Mode to prevent unreadable texts */
        .light-mode .text-white, 
        .light-mode .text-slate-55, 
        .light-mode .text-slate-50, 
        .light-mode .text-slate-100, 
        .light-mode .text-slate-200 {
            color: var(--text-primary) !important;
        }
        .light-mode .text-slate-300, 
        .light-mode .text-slate-400,
        .light-mode .text-slate-600 {
            color: var(--text-secondary) !important;
        }
        .light-mode .text-slate-500,
        .light-mode .text-slate-700,
        .light-mode .text-slate-750 {
            color: var(--text-muted) !important;
        }

        /* High-Contrast Highlights Overrides for Light Mode (No more faded gold/green/purple texts!) */
        .light-mode .text-brand-300,
        .light-mode .text-brand-400 {
            color: #7c3aed !important; /* brand-600 dark purple */
        }
        .light-mode .text-brand-500 {
            color: #6d28d9 !important; /* brand-700 */
        }
        .light-mode .text-amber-400,
        .light-mode .text-amber-500 {
            color: #b45309 !important; /* amber-700 dark golden-yellow */
        }
        .light-mode .text-emerald-400,
        .light-mode .text-emerald-500 {
            color: #047857 !important; /* emerald-700 dark green */
        }
        .light-mode .text-indigo-400,
        .light-mode .text-indigo-500 {
            color: #4f46e5 !important; /* indigo-600 dark indigo */
        }
        .light-mode .text-rose-400,
        .light-mode .text-rose-500 {
            color: #e11d48 !important; /* rose-600 dark red */
        }
        .light-mode .text-sky-400,
        .light-mode .text-sky-500 {
            color: #0284c7 !important; /* sky-600 dark blue */
        }

        /* Card highlight background overrides for clean contrast */
        .light-mode .bg-brand-500\/10, .light-mode .bg-brand-500\/20 {
            background-color: rgba(124, 58, 237, 0.12) !important;
            border-color: rgba(124, 58, 237, 0.25) !important;
        }
        .light-mode .bg-amber-500\/10, .light-mode .bg-amber-500\/20 {
            background-color: rgba(217, 119, 6, 0.12) !important;
            border-color: rgba(217, 119, 6, 0.25) !important;
        }
        .light-mode .bg-emerald-500\/10, .light-mode .bg-emerald-500\/20 {
            background-color: rgba(5, 150, 105, 0.12) !important;
            border-color: rgba(5, 150, 105, 0.25) !important;
        }
        .light-mode .bg-rose-500\/10, .light-mode .bg-rose-500\/20 {
            background-color: rgba(225, 29, 72, 0.12) !important;
            border-color: rgba(225, 29, 72, 0.25) !important;
        }

        /* Text title gradient resets (keep them clean in light mode) */
        .light-mode .bg-clip-text {
            background: none !important;
            background-clip: unset !important;
            -webkit-background-clip: unset !important;
            color: var(--text-primary) !important;
            -webkit-text-fill-color: var(--text-primary) !important;
        }

        /* Dashboard welcome card text stays white because of the dark background gradient */
        .light-mode .dashboard-welcome-card h2, 
        .light-mode .dashboard-welcome-card p, 
        .light-mode .dashboard-welcome-card span {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Card and items background overrides */
       }

        /* Card border overrides globally for clean Light Mode borders */
        .light-mode .border-slate-800,
        .light-mode .border-slate-800\/80,
        .light-mode .border-slate-800\/60,
        .light-mode .border-slate-800\/30,
        .light-mode .border-slate-750,
        .light-mode .border-slate-900,
        .light-mode .divide-slate-800\/40 {
            border-color: var(--border-card) !important;
        }

        /* Small icon backgrounds inside cards */
        .light-mode .light-panel {
            background-color: var(--bg-card) !important;
            border-color: var(--border-card) !important;
            color: var(--text-primary) !important;
        }

        /* Light mode: force any slate background utilities to use the page background */
/* Light mode: force any Tailwind slate background utility to use the light page background */
.light-mode [class*="bg-slate-"] {
    background-color: var(--bg-body) !important;
    background-image: none !important;
    color: var(--text-primary) !important;
    transition: background-color 0.25s ease !important;
}
        .light-mode .bg-slate-800:hover, 
        .light-mode .bg-slate-900:hover,
        .light-mode .bg-slate-800\/60:hover {
            background-color: var(--bg-card-hover) !important;
        }

        /* Inputs & select forms overrides */
        /* Light mode overrides for default dark utility classes */

        /* Light‑mode core overrides */

.light-mode [class*="text-slate-"] { color: var(--text-primary) !important; }
.light-mode [class*="border-slate-"] { border-color: var(--border-card) !important; }
        /* Adjust text colors for light mode */
.light-mode .text-white { color: var(--text-primary) !important; }

/* SweetAlert light‑mode styling */
.light-mode .swal2-popup {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border: 1px solid var(--border-card) !important;
}
.light-mode .swal2-title, .light-mode .swal2-html-container, .light-mode .swal2-content {
    color: var(--text-primary) !important;
}
.light-mode .swal2-confirm {
    color: #fff !important;
}
.light-mode .swal2-cancel {
    color: var(--text-primary) !important;
}

            background-color: var(--bg-frame) !important;
            color: var(--text-primary) !important;
        }

        .light-mode .mobile-frame input,
        .light-mode .mobile-frame select,
        .light-mode .mobile-frame textarea {
            background-color: var(--bg-input) !important;
            color: var(--text-input) !important;
            border-color: var(--border-color) !important;
        }
        .light-mode input, 
        .light-mode select, 
        .light-mode textarea {
            background-color: var(--bg-input) !important;
            border-color: var(--border-color) !important;
            color: var(--text-input) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease !important;
        }
        .light-mode input::placeholder, 
        .light-mode textarea::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.8;
        }

        /* Locked grid elements */
        .light-mode .bg-slate-950\/60 {
            background-color: rgba(255, 255, 255, 0.45) !important;
        }
        .light-mode .border-dashed {
            border-color: var(--border-color) !important;
        }

        /* Target numerical keyboard for scoring (panahan/sesi.php) */
        .light-mode .bg-slate-900\/90 {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-color: var(--border-color) !important;
        }
        .light-mode button[onclick^="inputScore"], 
        .light-mode button[onclick^="deleteScore"] {
            background-color: var(--bg-card) !important;
            border-color: var(--border-card) !important;
            color: var(--text-primary) !important;
        }
        .light-mode button[onclick^="inputScore"]:hover, 
        .light-mode button[onclick^="deleteScore"]:hover {
            background-color: var(--bg-card-hover) !important;
        }

        /* High-Contrast Interactive Scoring Grid in Light Mode */
        /* Additional light mode slate utility overrides */
        .light-mode .bg-slate-850 {
            background-color: var(--bg-card) !important;
        }
        .light-mode .bg-slate-950 {
            background-color: var(--bg-card) !important;
        }
        /* Generic Slate Utility Overrides for Light Mode */
        .light-mode [class*="bg-slate-"] {
            background-color: var(--bg-card) !important;
        }
        .light-mode [class*="text-slate-"] {
            color: var(--text-primary) !important;
        }
        .light-mode [class*="border-slate-"] {
            border-color: var(--border-card) !important;
        }
        .light-mode thead {
            background-color: #f1f5f9 !important; /* Clean light gray */
            border-bottom: 2px solid rgba(15, 23, 42, 0.08) !important;
        }
        .light-mode thead th {
            color: var(--text-primary) !important;
            font-weight: 800 !important;
        }
        .light-mode tfoot {
            background-color: #e2e8f0 !important; /* Slightly darker light gray for footer emphasis */
            border-top: 2px solid rgba(15, 23, 42, 0.12) !important;
        }
        .light-mode tfoot td {
            color: var(--text-primary) !important;
            font-weight: 800 !important;
        }
        .light-mode tr.hover\:bg-slate-900\/10:hover,
        .light-mode tr.hover\:bg-slate-900\/20:hover {
            background-color: rgba(15, 23, 42, 0.03) !important;
        }
        .light-mode td.border-r,
        .light-mode td.border-l,
        .light-mode td.border-x,
        .light-mode th.border-r,
        .light-mode th.border-l,
        .light-mode th.border-x {
            border-color: rgba(15, 23, 42, 0.08) !important;
        }
        .light-mode .divide-slate-800\/40 > tr {
            border-bottom-color: rgba(15, 23, 42, 0.08) !important;
        }
        .light-mode td.text-slate-500,
        .light-mode th.text-slate-500 {
            color: var(--text-secondary) !important;
        }
        .light-mode td.bg-slate-900\/20 {
            background-color: rgba(15, 23, 42, 0.04) !important;
        }
        .light-mode td.text-slate-400 {
            color: var(--text-secondary) !important;
        }
        .light-mode button[data-arrow].bg-slate-900\/60 {
            background-color: #e2e8f0 !important;
            border-color: rgba(15, 23, 42, 0.15) !important;
            color: #475569 !important;
        }
        .light-mode button[data-arrow].bg-slate-900\/60:hover {
            background-color: #cbd5e1 !important;
            color: var(--text-primary) !important;
        }


        /* Global SweetAlert2 Theme Adjustments for Light Mode */
        .light-mode .swal2-popup {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }
        .light-mode .swal2-title,
        .light-mode .swal2-html-container,
        .light-mode .swal2-content {
            color: #0f172a !important;
        }
        .light-mode .swal2-html-container strong {
            color: #7c3aed !important;
        }
        .light-mode .swal2-cancel {
            background-color: #e2e8f0 !important;
            color: #334155 !important;
        }

        /* Standard CSS Animations */
        @keyframes premium-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes premium-ping {
            0% { transform: scale(1); opacity: 0.75; }
            75%, 100% { transform: scale(1.6); opacity: 0; }
        }

        @keyframes premium-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(0.85); }
        }
    </style>
</head>
<body class="h-full flex items-center justify-center overflow-x-hidden md:py-4">

    <!-- Mobile App Container -->
    <div class="mobile-frame w-full max-w-md h-full md:h-[840px] md:rounded-[36px] bg-slate-900 text-slate-100 flex flex-col overflow-hidden relative border border-slate-800">
        
        <!-- Top Header (Glassmorphic) -->
        <div class="px-5 py-3.5 bg-slate-900/90 backdrop-blur-md border-b border-slate-800/80 flex items-center justify-between shrink-0 z-20 sticky top-0">
            <div class="flex items-center gap-3">
                <?php if (isset($show_back) && $show_back): ?>
                    <a href="<?= $back_url ?? 'javascript:history.back()' ?>" class="w-8 h-8 rounded-full bg-slate-800/60 hover:bg-slate-800 flex items-center justify-center transition-all text-slate-300 hover:text-white">
                        <i class='bx bx-chevron-left text-2xl'></i>
                    </a>
                <?php endif; ?>
                <div>
                    <h1 class="text-lg font-bold bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent flex items-center gap-2">
                        <?= $title ?? 'Scoring' ?>
                    </h1>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <?php if (session()->get('active_cabor') && (!isset($hide_ganti_cabor) || !$hide_ganti_cabor)): ?>
                    <a href="/sports" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 hover:bg-brand-500/20 text-brand-400 hover:text-brand-300 text-[10px] font-bold uppercase tracking-wider transition-all">
                        <i class='bx bx-refresh text-sm'></i> Ganti
                    </a>
                <?php endif; ?>
                <button onclick="toggleDarkMode()" class="w-8 h-8 rounded-full bg-slate-800/60 hover:bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white transition-all">
                    <i class='bx bx-brightness-half text-lg'></i>
                </button>
            </div>
        </div>

        <!-- Main Viewport Content Area -->
        <div class="flex-1 overflow-y-scroll no-scrollbar pb-24 px-4 py-4 relative bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950">
            <!-- Alert Messages (Dynamic CI4 Flashdata) -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-xs flex items-center gap-2">
                    <i class='bx bx-check-circle text-base shrink-0'></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 p-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-xs flex items-center gap-2">
                    <i class='bx bx-error-circle text-base shrink-0'></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <!-- Render views here -->
            <?= $this->renderSection('content') ?>
            
            <!-- Animated Copyright Footer -->
            <div class="mt-12 mb-6 flex flex-col items-center justify-center text-center animate-[pulse_4s_ease-in-out_infinite] select-none">
                <div class="flex items-center justify-center gap-1.5 mb-1.5">
                    <span class="w-6 h-[1px] bg-gradient-to-r from-transparent to-brand-500/50"></span>
                    <i class='bx bxs-bolt text-brand-400 text-sm animate-bounce'></i>
                    <span class="w-6 h-[1px] bg-gradient-to-l from-transparent to-brand-500/50"></span>
                </div>
                <p class="text-[10px] font-medium text-slate-500">
                    &copy; <?= date('Y') ?> <a href="https://appsbee.my.id" target="_blank" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-sky-400 hover:from-brand-300 hover:to-sky-300 transition-all">appsbee.my.id</a>
                </p>
            </div>
        </div>

        <!-- Bottom Navigation Bar (Android Premium Style) -->
        <?php if (!isset($hide_bottom_nav) || !$hide_bottom_nav): ?>
            <?php 
                $active_menu = $active_menu ?? 'dashboard'; 
            ?>
            <div class="absolute bottom-0 inset-x-0 bg-slate-950/95 backdrop-blur-lg border-t border-slate-900 px-6 py-2.5 flex items-center justify-between shrink-0 z-30 md:rounded-b-[36px]">
                <!-- Nav Item: Dashboard -->
                <?php 
                    // Need to define brandColor here too for the Dashboard nav item since it is before Scoring nav item
                    $caborNav = session()->get('active_cabor');
                    $brandColorNav = ($caborNav && strtolower($caborNav) === 'bulutangkis') ? 'emerald' : 'brand';
                ?>
                <a href="/" class="flex flex-col items-center gap-1 group transition-all <?= $active_menu === 'dashboard' ? 'text-'.$brandColorNav.'-400' : 'text-slate-500 hover:text-slate-300' ?>">
                    <div class="w-12 h-7 rounded-full flex items-center justify-center transition-all <?= $active_menu === 'dashboard' ? 'bg-'.$brandColorNav.'-500/20' : 'group-hover:bg-slate-800/30' ?>">
                        <i class='bx bx-home-alt text-xl'></i>
                    </div>
                    <span class="text-[10px] font-semibold tracking-wide">Dashboard</span>
                </a>

                <!-- Nav Item: Scoring -->
                <?php 
                    $cabor = session()->get('active_cabor');
                    $isComingSoon = false;
                    $caborLower = $cabor ? strtolower($cabor) : '';
                    if ($caborLower === 'panahan' || $caborLower === 'bulutangkis') {
                        $activeCaborLink = '/' . $caborLower;
                    } else if ($cabor) {
                        $activeCaborLink = '#';
                        $isComingSoon = true;
                    } else {
                        $activeCaborLink = '/sports';
                    }
                    
                    $brandColor = $caborLower === 'bulutangkis' ? 'emerald' : 'brand';
                ?>
                <a href="<?= $activeCaborLink ?>" <?= $isComingSoon ? "onclick=\"showGlobalComingSoon('".esc($cabor)."'); return false;\"" : "" ?> class="flex flex-col items-center gap-1 group transition-all <?= $active_menu === 'scoring' ? 'text-'.$brandColor.'-400' : 'text-slate-500 hover:text-slate-300' ?>">
                    <div class="w-12 h-7 rounded-full flex items-center justify-center transition-all <?= $active_menu === 'scoring' ? 'bg-'.$brandColor.'-500/20' : 'group-hover:bg-slate-800/30' ?>">
                        <i class='bx <?= $caborLower === 'bulutangkis' ? 'bx-tennis-ball' : 'bx-target-lock' ?> text-xl'></i>
                    </div>
                    <span class="text-[10px] font-semibold tracking-wide">Scoring</span>
                </a>

                <!-- Nav Item: Atlet -->
                <a href="/anggota" class="flex flex-col items-center gap-1 group transition-all <?= $active_menu === 'anggota' ? 'text-'.$brandColor.'-400' : 'text-slate-500 hover:text-slate-300' ?>">
                    <div class="w-12 h-7 rounded-full flex items-center justify-center transition-all <?= $active_menu === 'anggota' ? 'bg-'.$brandColor.'-500/20' : 'group-hover:bg-slate-800/30' ?>">
                        <i class='bx bx-group text-xl'></i>
                    </div>
                    <span class="text-[10px] font-semibold tracking-wide">Atlet</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- Full-screen Custom Sports Loading Overlay (Inside mobile-frame to clip beautifully, styled with pure premium-loader CSS) -->
        <div id="sports-loading-overlay" class="premium-loader">
            <div class="premium-loader-spinner-container">
                <!-- Target Outer Ring (Spinning) -->
                <div class="premium-loader-outer-ring"></div>
                <!-- Target Middle Ring (Pulsing Red) -->
                <div class="premium-loader-middle-ring"></div>
                <!-- Target Gold Center (Pulsing Icon) -->
                <div class="premium-loader-center">
                    <i class='bx bx-target-lock'></i>
                </div>
            </div>
            <h3 class="premium-loader-title" id="loading-title">MEMUAT HALAMAN</h3>
            <p class="premium-loader-subtitle" id="loading-subtitle">Sedang menyiapkan tampilan...</p>
        </div>

    </div>

    <!-- Script for Loader, Transitions, and Dark/Light Mode -->
    <script>
        // Hide the initial FOUC/FOUT loader ONLY after the page is 100% loaded, styled, and painted
        window.addEventListener('load', function() {
            // A tiny 80ms delay guarantees the browser has fully completed compiling and painting
            setTimeout(hideLoading, 80);
        });

        // Global PJAX SPA Navigation Handler to prevent hard reloads, blank flashes, and duplicate loader issues
        document.addEventListener('DOMContentLoaded', function() {
            // Bind AJAX navigation to all eligible links
            bindPjaxLinks();

            // Handle browser Back/Forward buttons
            window.addEventListener('popstate', function() {
                loadPjaxPage(window.location.href, false);
            });
        });

        function bindPjaxLinks() {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                const href = link.getAttribute('href');
                if (href && !href.startsWith('javascript') && !href.startsWith('#') && !link.hasAttribute('onclick') && !link.hasAttribute('download')) {
                    // Mark as bound to avoid duplicate binding if re-run
                    if (!link.hasAttribute('data-pjax-bound')) {
                        link.setAttribute('data-pjax-bound', 'true');
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            loadPjaxPage(href, true);
                        });
                    }
                }
            });
        }

        function loadPjaxPage(url, pushState = true) {
            // Show beautiful, smooth transparent loader instantly
            showLoading('MEMUAT HALAMAN', 'Sedang mengambil data...', false);

            // Fetch URL but disable caching so that data is always fresh (no stale pages on navigation)
            fetch(url, { 
                cache: 'no-store',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            })
                .then(res => {
                    if (!res.ok) throw new Error('HTTP error ' + res.status);
                    return res.text();
                })
                .then(html => {
                    // Parse the fetched HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Extract the content of the mobile frame
                    const newFrame = doc.querySelector('.mobile-frame');
                    const currentFrame = document.querySelector('.mobile-frame');

                    if (newFrame && currentFrame) {
                        // Replace the entire inner content of the mobile frame
                        currentFrame.innerHTML = newFrame.innerHTML;
                        
                        // Update the document title
                        document.title = doc.title;

                        // Push new URL to browser history
                        if (pushState) {
                            history.pushState(null, '', url);
                        }

                        // Re-bind links on the new content
                        bindPjaxLinks();

                        // Re-execute any scripts inside the new content (like Chart.js or Page Scripts)
                        const scripts = currentFrame.querySelectorAll('script');
                        scripts.forEach(script => {
                            const newScript = document.createElement('script');
                            if (script.src) {
                                newScript.src = script.src;
                            } else {
                                newScript.textContent = script.textContent;
                            }
                            document.body.appendChild(newScript);
                            newScript.remove(); // Clean up from DOM after execution
                        });

                        // Sync active menu state or any global triggers
                        updateThemeIcon();
                    }
                    
                    // Smoothly fade out the loader once page content is successfully swapped and scripts execute
                    setTimeout(hideLoading, 150);
                })
                .catch(err => {
                    console.error('PJAX Navigation Error:', err);
                    // Fallback to native navigation in case of error
                    window.location.href = url;
                });
        }

        // Global Coming Soon Alert for Bottom Nav
        function showGlobalComingSoon(sportName) {
            Swal.fire({
                title: sportName,
                text: `Modul scoring pertandingan untuk ${sportName} sedang dalam tahap pengembangan. Pantau terus pembaruan berikutnya!`,
                icon: 'info',
                background: (document.documentElement.classList.contains('light-mode') ? '#ffffff' : '#1e293b'),
                color: (document.documentElement.classList.contains('light-mode') ? '#0f172a' : '#f8fafc'),
                confirmButtonColor: '#8b5cf6',
                confirmButtonText: 'Siap, Ditunggu!'
            });
        }

        function showLoading(title = 'MEMPROSES DATA', subtitle = 'Harap tunggu sebentar...', isPageTransition = false) {
            const overlay = document.getElementById('sports-loading-overlay');
            const titleEl = document.getElementById('loading-title');
            const subEl = document.getElementById('loading-subtitle');
            
            if (overlay) {
                if (titleEl) titleEl.textContent = title;
                if (subEl) subEl.textContent = subtitle;
                
                // Determine layout background dynamically based on theme and context to prevent theme flashes and paint glitches
                const isLight = document.documentElement.classList.contains('light-mode');
                
                if (isPageTransition) {
                    // Page transitions use 100% solid background matching the active theme to prevent double blinks and keep paint-holding clean
                    const solidBg = isLight ? '#ffffff' : '#0f172a';
                    overlay.style.setProperty('background-color', solidBg, 'important');
                } else {
                    // AJAX/Actions use beautiful highly-opaque dimming backgrounds
                    const dimBg = isLight ? 'rgba(255, 255, 255, 0.92)' : 'rgba(15, 23, 42, 0.94)';
                    overlay.style.setProperty('background-color', dimBg, 'important');
                }
                
                overlay.style.setProperty('opacity', '1', 'important');
                overlay.style.removeProperty('backdrop-filter');
                overlay.style.removeProperty('-webkit-backdrop-filter');
                
                overlay.classList.remove('hidden');
            }
        }

        function hideLoading() {
            const overlay = document.getElementById('sports-loading-overlay');
            if (overlay) {
                // Smoothly fade out opacity first, then apply hidden display
                overlay.style.setProperty('opacity', '0', 'important');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    // Reset inline style properties to default stylesheet values
                    overlay.style.removeProperty('opacity');
                    overlay.style.removeProperty('background-color');
                }, 300); // match transition duration
            }
        }

        // Update theme icon on DOMContentLoaded and theme toggles
        document.addEventListener('DOMContentLoaded', function() {
            updateThemeIcon();
        });

        function updateThemeIcon() {
            const btnIcon = document.querySelector('button[onclick="toggleDarkMode()"] i');
            if (btnIcon) {
                if (document.documentElement.classList.contains('light-mode')) {
                    btnIcon.className = 'bx bx-moon text-lg'; // Show moon icon in light mode to switch back
                } else {
                    btnIcon.className = 'bx bx-sun text-lg'; // Show sun icon in dark mode to switch to light
                }
            }
        }

        // Premium Dark/Light Mode toggle helper (Full persistence & Toast updates)
        function toggleDarkMode() {
            const isLight = document.documentElement.classList.toggle('light-mode');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            updateThemeIcon();
            
            // Show a beautiful, polished SweetAlert Toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                icon: 'success',
                title: isLight ? 'Mode Terang Aktif' : 'Mode Gelap Aktif',
                background: isLight ? '#ffffff' : '#1e293b',
                color: isLight ? '#0f172a' : '#f8fafc',
            });
        }
    </script>

</body>
</html>
