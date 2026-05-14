<?php
ob_start();
session_start();
include 'config/db.php';

$allowedPages = ['home', 'about', 'contact', 'login', 'level', 'studies'];
$page = $_GET['page'] ?? 'home';
if (!in_array($page, $allowedPages, true)) {
    $page = 'home';
}

$pageTitles = [
    'home' => 'Home | Dhio Patty Alexander',
    'about' => 'About Me | Dhio Patty Alexander',
    'contact' => 'Contact Me | Dhio Patty Alexander',
    'login' => 'Login | Dhio Patty Alexander',
    'level' => 'CRUD Level | Dhio Patty Alexander',
    'studies' => 'CRUD Studies | Dhio Patty Alexander',
];

// Enforce authentication: only login page is accessible without login
$publicPages = ['login'];
if (!isset($_SESSION['user']) && !in_array($page, $publicPages, true)) {
    $page = 'login';
    $pageNotice = 'Silakan login terlebih dahulu untuk mengakses website.';
}

// If already logged in and trying to access login, redirect to home
if (isset($_SESSION['user']) && $page === 'login') {
    header("Location: index.php?page=home");
    exit;
}

if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitles[$page] ?? 'Dhio Patty Alexander') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --color-primary: #10243f;
            --color-primary-light: #18365f;
            --color-secondary: #126f86;
            --color-secondary-light: #1da2a6;
            --color-accent: #f4b860;
            --color-accent-dark: #c98c31;
            --color-highlight: #eb6f7d;
            --color-bg-light: #eef3fb;
            --color-surface: rgba(255, 255, 255, 0.86);
            --color-surface-strong: #ffffff;
            --color-text-primary: #1c2740;
            --color-text-secondary: #66758b;
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-2xl: 1.5rem;
            --shadow-sm: 0 6px 18px rgba(16, 36, 63, 0.08);
            --shadow-md: 0 18px 40px rgba(16, 36, 63, 0.12);
            --shadow-lg: 0 28px 60px rgba(16, 36, 63, 0.18);
            --border-radius: 16px;
            --border-color: rgba(16, 36, 63, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(29, 162, 166, 0.16), transparent 32%),
                radial-gradient(circle at top right, rgba(244, 184, 96, 0.16), transparent 28%),
                radial-gradient(circle at bottom left, rgba(235, 111, 125, 0.12), transparent 26%),
                linear-gradient(145deg, #f7fbff 0%, #edf4fb 45%, #eef3fb 100%);
            background-attachment: fixed;
            background-size: cover;
            color: var(--color-text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            font-size: var(--text-base);
            font-weight: 400;
            min-height: 100vh;
            position: relative;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            width: 28rem;
            height: 28rem;
            border-radius: 50%;
            filter: blur(10px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.45;
            animation: floatBlob 16s ease-in-out infinite;
        }

        body::before {
            top: -8rem;
            right: -8rem;
            background: radial-gradient(circle, rgba(29, 162, 166, 0.26), rgba(29, 162, 166, 0));
        }

        body::after {
            bottom: -10rem;
            left: -10rem;
            background: radial-gradient(circle, rgba(235, 111, 125, 0.20), rgba(235, 111, 125, 0));
            animation-delay: -8s;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 800;
            line-height: 1.15;
            color: var(--color-primary);
            margin-bottom: var(--spacing-md);
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }
        h5 { font-size: 1.125rem; }
        h6 { font-size: 1rem; }

        p {
            color: var(--color-text-secondary);
            margin-bottom: var(--spacing-md);
        }

        .app-shell {
            max-width: 1320px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .portfolio-panel,
        .card,
        .alert,
        .modal-content,
        .list-group,
        .navbar {
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            backdrop-filter: blur(18px);
        }

        .portfolio-panel {
            background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.78));
            animation: fadeUp 0.7s ease both;
        }

        .card {
            background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.82));
            border-color: var(--border-color);
            overflow: hidden;
        }

        .card-body {
            padding: var(--spacing-xl);
        }

        .section-label {
            display: block;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-size: var(--text-xs);
            font-weight: 800;
            color: var(--color-secondary);
            margin-bottom: var(--spacing-md);
        }

        .section-label::after {
            content: '';
            display: block;
            width: 42px;
            height: 3px;
            margin-top: 8px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-secondary), var(--color-accent));
        }

        .skill-pill {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            border-radius: 999px;
            padding: var(--spacing-sm) var(--spacing-lg);
            background: linear-gradient(135deg, rgba(29, 162, 166, 0.1), rgba(244, 184, 96, 0.18));
            color: #0f4f63;
            font-size: var(--text-sm);
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            border: 1px solid rgba(16, 36, 63, 0.06);
        }

        .skill-pill:hover {
            background: linear-gradient(135deg, rgba(29, 162, 166, 0.18), rgba(244, 184, 96, 0.26));
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 14px 24px rgba(16, 36, 63, 0.10);
        }

        .badge {
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 6px;
            font-weight: 600;
            font-size: var(--text-sm);
        }

        .btn {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease, border-color 0.25s ease;
            border: none;
        }

        .btn-dark {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: white;
            box-shadow: 0 12px 24px rgba(16, 36, 63, 0.14);
        }

        .btn-dark:hover {
            background: linear-gradient(135deg, var(--color-primary-light), var(--color-secondary-light));
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline-light {
            border: 1.5px solid rgba(255, 255, 255, 0.72);
            color: white;
            background: rgba(255, 255, 255, 0.06);
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: white;
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--color-accent), #f59f57);
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f6c06f, var(--color-accent-dark));
            transform: translateY(-2px);
        }

        .navbar {
            background: linear-gradient(135deg, rgba(16, 36, 63, 0.92), rgba(24, 54, 95, 0.88), rgba(18, 111, 134, 0.82));
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(18px);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
            color: white !important;
            text-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.82) !important;
            font-weight: 500;
            transition: color 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            color: white !important;
        }

        .nav-link.active {
            color: var(--color-accent) !important;
            font-weight: 700;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0.25rem;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--color-accent), var(--color-secondary-light));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.25s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
        }

        .dropdown-menu {
            background: rgba(18, 39, 68, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.82);
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .dropdown-item.active {
            background: linear-gradient(135deg, var(--color-accent), #f59f57);
            color: white;
        }

        .hero-banner,
        .page-banner {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            position: relative;
            animation: fadeUp 0.8s ease both;
        }

        .hero-banner img,
        .page-banner img {
            object-fit: cover;
            height: 100%;
            transform: scale(1.01);
            filter: saturate(1.12) contrast(1.04);
        }

        .hero-slide-image {
            height: 400px;
            object-fit: cover;
        }

        .hero-caption {
            min-height: 210px;
        }

        .carousel-caption {
            background: linear-gradient(135deg, rgba(16, 36, 63, 0.82), rgba(18, 111, 134, 0.72)) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(14px);
            border-radius: 22px;
            padding: 1.5rem 1.5rem 1.25rem;
            left: 50% !important;
            transform: translateX(-50%);
            width: min(88%, 760px);
            bottom: 1.5rem;
        }

        .card-hover {
            transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(29, 162, 166, 0.24);
        }

        .list-group-item {
            border-color: var(--border-color);
            background: var(--color-surface);
        }

        .list-group-item.active {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .portfolio-footer {
            background: linear-gradient(135deg, rgba(16, 36, 63, 0.06), rgba(29, 162, 166, 0.06), rgba(244, 184, 96, 0.08));
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            position: relative;
        }

        .alert {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .form-control,
        .form-select {
            border-color: var(--border-color);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: var(--text-base);
            background: rgba(255, 255, 255, 0.92);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(244, 184, 96, 0.18);
        }

        .bg-light {
            background-color: var(--color-bg-light) !important;
        }

        .text-secondary {
            color: var(--color-text-secondary) !important;
        }

        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }

        .page-enter {
            animation: fadeUp 0.75s ease both;
        }

        .sidebar {
            display: block;
        }

        .sidebar .sidebar-card {
            margin-bottom: 1rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.94), rgba(245,250,255,0.86));
        }

        .sidebar .card-body {
            padding: 1rem;
        }

        .sidebar .profile-img {
            width: 72px !important;
            height: 72px !important;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.72);
            box-shadow: 0 10px 22px rgba(16, 36, 63, 0.14);
        }

        .sidebar .profile-name {
            font-size: 1rem;
            font-weight: 700;
        }

        .sidebar .sidebar-meta .py-1 {
            border-bottom: 1px dashed rgba(0,0,0,0.04);
        }

        .sidebar .skill-pill {
            padding: 6px 10px;
            font-size: 0.8125rem;
            background: linear-gradient(135deg, rgba(29, 162, 166, 0.12), rgba(244, 184, 96, 0.18));
            color: #0f4f63;
        }

        .sidebar a.btn {
            border-radius: 999px;
        }

        .sidebar ul {
            padding-left: 1rem;
        }

        .sidebar li + li {
            margin-top: 0.35rem;
        }

        .portfolio-panel h2,
        .portfolio-panel h3,
        .portfolio-panel h4,
        .portfolio-panel h5 {
            color: var(--color-primary);
        }

        .panel-gradient-royal {
            background: linear-gradient(135deg, rgba(16, 36, 63, 0.96), rgba(24, 54, 95, 0.88), rgba(18, 111, 134, 0.86));
            color: white;
        }

        .panel-gradient-sunrise {
            background: linear-gradient(135deg, rgba(244, 184, 96, 0.28), rgba(235, 111, 125, 0.18), rgba(255, 255, 255, 0.88));
        }

        .panel-gradient-ocean {
            background: linear-gradient(135deg, rgba(29, 162, 166, 0.14), rgba(16, 36, 63, 0.04), rgba(255, 255, 255, 0.88));
        }

        .panel-gradient-forest {
            background: linear-gradient(135deg, rgba(34, 139, 122, 0.14), rgba(244, 184, 96, 0.12), rgba(255, 255, 255, 0.9));
        }

        .panel-gradient-instagram {
            background: linear-gradient(135deg, rgba(193, 53, 132, 0.16), rgba(137, 43, 226, 0.12), rgba(255, 255, 255, 0.9));
        }

        .panel-gradient-whatsapp {
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.16), rgba(25, 118, 210, 0.08), rgba(255, 255, 255, 0.9));
        }

        .section-sheen {
            position: relative;
            overflow: hidden;
        }

        /* Ensure Bootstrap modals appear above transformed stacking contexts */
        .modal {
            z-index: 11050 !important;
        }
        .modal-backdrop {
            z-index: 11040 !important;
        }

        .section-sheen::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.18), rgba(255,255,255,0));
            pointer-events: none;
        }

        .hero-feature {
            overflow: hidden;
        }

        .hero-feature-panel {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary), var(--color-secondary-light));
            color: white;
        }

        .contact-icon {
            width: 72px;
            height: 72px;
            color: white;
            font-weight: 800;
            font-size: 1.25rem;
            box-shadow: 0 12px 26px rgba(16, 36, 63, 0.16);
        }

        .contact-icon-wrap {
            width: 78px;
            height: 78px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 14px 28px rgba(16, 36, 63, 0.12);
        }

        .contact-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .contact-icon-linkedin {
            background: linear-gradient(135deg, #0a66c2, #1877f2);
        }

        .contact-icon-github {
            background: linear-gradient(135deg, #24292f, #4b5563);
        }

        .contact-icon-email {
            background: linear-gradient(135deg, var(--color-accent), var(--color-highlight));
        }

        .login-shell {
            min-height: 500px;
        }

        .login-panel {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        }

        .hero-chip {
            background: rgba(255, 255, 255, 0.14) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .card .card-title {
            color: var(--color-primary);
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px) scale(0.98);
            filter: blur(4px);
            transition: opacity 0.7s ease, transform 0.7s ease, filter 0.7s ease;
            will-change: transform, opacity, filter;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        .reveal-delay-1 { transition-delay: 0.08s; }
        .reveal-delay-2 { transition-delay: 0.16s; }
        .reveal-delay-3 { transition-delay: 0.24s; }
        .reveal-delay-4 { transition-delay: 0.32s; }

        @keyframes floatBlob {
            0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
            50% { transform: translate3d(18px, 16px, 0) scale(1.06); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (min-width: 992px) {
            h1 { font-size: 3rem; }
            h2 { font-size: 2.2rem; }
        }

        @media (max-width: 991px) {
            .navbar {
                border-radius: 18px;
            }

            .carousel-caption {
                width: calc(100% - 1.5rem);
                padding: 1rem;
            }

            .hero-banner img,
            .page-banner img {
                min-height: 320px;
            }

            .card-body {
                padding: 1.1rem;
            }

            .sidebar .card-body {
                padding: 0.85rem;
            }
        }

        @media (max-width: 575px) {
            h1 { font-size: 1.9rem; }
            h2 { font-size: 1.55rem; }
            .section-label {
                letter-spacing: 0.12em;
            }
            .portfolio-panel,
            .card,
            .navbar,
            .alert,
            .modal-content {
                border-radius: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }

            .reveal {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }
    </style>
</head>
<body data-page="<?= e($page) ?>">
    <div class="container-fluid app-shell px-3 px-lg-4 py-3 py-lg-4">
        <?php include 'header.php'; ?>
        <?php include 'menu.php'; ?>

        <div class="container-fluid px-0 mt-4 main-content">
            <div class="row g-4">
                <div class="col-lg-3">
                    <?php include 'sidebar.php'; ?>
                </div>
                <div class="col-lg-9">
                    <div class="portfolio-panel p-4 p-lg-5 h-100">
                        <?php if ($db_error): ?>
                            <div class="alert alert-warning border-0 mb-4">
                                Database belum aktif. Halaman publik tetap bisa dibuka, tetapi menu CRUD akan menunggu MySQL Laragon tersambung.
                            </div>
                        <?php endif; ?>

                        <?php
                        $file = "pages/$page.php";
                        if (file_exists($file)) {
                            include $file;
                        } else {
                            echo "<div class='alert alert-danger'>Halaman tidak ditemukan!</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        (function () {
            const revealItems = Array.from(document.querySelectorAll('.reveal'));
            if (revealItems.length > 0 && 'IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.14,
                    rootMargin: '0px 0px -8% 0px',
                });

                revealItems.forEach((item) => revealObserver.observe(item));
            } else {
                revealItems.forEach((item) => item.classList.add('is-visible'));
            }
        })();
    </script>
</body>
</html>