<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $setting->site_title ?? 'Jauari Akhmad Nur Hasim')</title>
    <meta name="description" content="@yield('meta_description', $setting->meta_description ?? __('site.meta.description'))">
    <meta name="keywords" content="{{ $setting->meta_keywords ?? __('site.meta.keywords') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @if(! empty($setting?->favicon))
        <link rel="icon" href="{{ asset('storage/'.$setting->favicon) }}">
    @endif
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #f8fafc;
            --navy: #0f172a;
            --navy-soft: #1e293b;
            --brand-50: #f0fafc;
            --brand-100: #e6f7fb;
            --brand-300: #9bd8e4;
            --brand-500: #1c8faa;
            --brand-700: #095d75;
            --brand-800: #0a4759;
            --brand-900: #0a3543;
            --gold: #c8a24a;
            --muted: #a6b3c4;
            --line: rgba(255, 255, 255, .1);
            --surface: #111d32;
            --warm: #fafaf7;
        }

        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        body {
            color: var(--ink);
            background:
                radial-gradient(60% 50% at 12% 0%, rgba(70, 180, 210, .1) 0%, transparent 60%),
                radial-gradient(50% 40% at 100% 10%, rgba(200, 162, 74, .06) 0%, transparent 60%),
                var(--navy);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-feature-settings: "cv11", "ss01", "ss03";
            overflow-x: hidden;
            padding-top: 80px;
        }
        body.theme-light {
            --ink: #0f172a;
            --muted: #64748b;
            --line: rgba(15, 23, 42, .08);
            --surface: #f8fafc;
            color: var(--ink);
            background:
                radial-gradient(60% 50% at 12% 0%, rgba(9, 93, 117, .1) 0%, transparent 60%),
                radial-gradient(50% 40% at 100% 10%, rgba(200, 162, 74, .08) 0%, transparent 60%),
                var(--warm);
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--ink);
            font-family: "Plus Jakarta Sans", Inter, ui-sans-serif, system-ui, sans-serif;
            letter-spacing: 0;
        }
        a { color: var(--brand-300); }
        a:hover { color: #fff; }
        .navbar {
            min-height: 80px;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            background: rgba(15, 23, 42, .82);
            backdrop-filter: saturate(180%) blur(14px);
            box-shadow: 0 4px 24px rgba(0, 0, 0, .18);
        }
        body.theme-light .navbar {
            border-bottom-color: rgba(15, 23, 42, .08);
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 4px 24px rgba(15, 23, 42, .06);
        }
        .navbar-brand { color: #fff; }
        .navbar-brand:hover { color: #fff; }
        body.theme-light .navbar-brand,
        body.theme-light .navbar-brand:hover {
            color: var(--navy);
        }
        .navbar-toggler {
            border-color: rgba(255, 255, 255, .16);
            filter: invert(1) grayscale(1);
        }
        body.theme-light .navbar-toggler { filter: none; }
        .brand-mark {
            width: 2.35rem;
            height: 2.35rem;
            display: inline-grid;
            place-items: center;
            border-radius: .8rem;
            background: var(--brand-700);
            color: #fff;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-weight: 800;
        }
        .nav-link {
            color: rgba(226, 232, 240, .86);
            border-radius: 999px;
            font-weight: 600;
            font-size: .9rem;
            padding-inline: .75rem !important;
        }
        body.theme-light .nav-link {
            color: rgba(15, 23, 42, .78);
        }
        .nav-link:hover {
            color: var(--brand-300);
            background: rgba(255, 255, 255, .06);
        }
        body.theme-light .nav-link:hover {
            color: var(--brand-700);
            background: var(--brand-50);
        }
        .navbar-nav .nav-link.active {
            color: rgba(226, 232, 240, .86);
            background: transparent;
        }
        body.theme-light .navbar-nav .nav-link.active {
            color: rgba(15, 23, 42, .78);
            background: transparent;
        }
        .theme-toggle,
        .language-toggle {
            width: 2.4rem;
            height: 2.4rem;
            display: inline-grid;
            place-items: center;
            border: 0;
            border-radius: 999px;
            color: rgba(226, 232, 240, .92);
            background: transparent;
        }
        .language-toggle {
            border: 1px solid rgba(155, 216, 228, .22);
            color: var(--brand-300);
            font-size: .76rem;
            font-weight: 800;
            text-decoration: none;
        }
        .theme-toggle:hover,
        .language-toggle:hover {
            color: #fff;
            background: rgba(255, 255, 255, .06);
        }
        body.theme-light .theme-toggle,
        body.theme-light .language-toggle {
            color: var(--navy);
        }
        body.theme-light .language-toggle {
            color: var(--brand-700);
            border-color: rgba(9, 93, 117, .18);
        }
        body.theme-light .theme-toggle:hover,
        body.theme-light .language-toggle:hover {
            color: var(--brand-700);
            background: var(--brand-50);
        }
        .btn-primary {
            --bs-btn-bg: var(--brand-700);
            --bs-btn-border-color: var(--brand-700);
            --bs-btn-hover-bg: var(--brand-800);
            --bs-btn-hover-border-color: var(--brand-800);
            --bs-btn-color: #fff;
        }
        .btn-outline-primary {
            --bs-btn-color: var(--brand-300);
            --bs-btn-border-color: rgba(155, 216, 228, .35);
            --bs-btn-hover-bg: rgba(155, 216, 228, .12);
            --bs-btn-hover-border-color: var(--brand-300);
            --bs-btn-hover-color: #fff;
        }
        .btn {
            border-radius: 999px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 .75rem 1.75rem rgba(9, 93, 117, .22);
        }
        .section { padding: 88px 0; }
        .section-soft { background: rgba(255, 255, 255, .025); }
        .section-title { max-width: 760px; margin-bottom: 36px; }
        .section-kicker {
            color: var(--brand-300);
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-size: .78rem;
        }
        .text-secondary,
        .text-muted {
            color: var(--muted) !important;
        }
        body.theme-light .text-secondary,
        body.theme-light .text-muted {
            color: var(--muted) !important;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border: 1px solid rgba(155, 216, 228, .2);
            background: rgba(155, 216, 228, .08);
            color: var(--brand-300);
            border-radius: 999px;
            padding: .45rem .85rem;
            font-size: .8rem;
            font-weight: 700;
        }
        .chip-dot {
            width: .4rem;
            height: .4rem;
            border-radius: 999px;
            background: var(--brand-500);
        }
        .hero {
            min-height: calc(100vh - 80px);
            padding: 80px 0 96px;
            background:
                radial-gradient(60% 50% at 12% 0%, rgba(70, 180, 210, .13) 0%, transparent 60%),
                radial-gradient(50% 40% at 100% 10%, rgba(200, 162, 74, .09) 0%, transparent 60%),
                radial-gradient(40% 35% at 50% 100%, rgba(80, 200, 235, .08) 0%, transparent 60%),
                linear-gradient(110deg, rgba(15, 23, 42, .96), rgba(15, 23, 42, .92)),
                var(--hero-bg, none);
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .hero h1 {
            font-size: clamp(2.55rem, 5.6vw, 5.2rem);
            line-height: 1.05;
            letter-spacing: 0;
        }
        .hero-copy {
            color: rgba(226, 232, 240, .82);
            max-width: 720px;
            line-height: 1.75;
        }
        .hero-stat-label {
            color: rgba(226, 232, 240, .62);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .hero-stat-value {
            color: var(--brand-300);
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: clamp(1.9rem, 3.5vw, 3rem);
            font-weight: 800;
            line-height: 1;
        }
        .metric-value {
            overflow-wrap: anywhere;
            font-size: clamp(1.45rem, 3.8vw, 2rem);
            line-height: 1.15;
        }
        .profile-frame {
            width: min(100%, 360px);
            aspect-ratio: 4 / 5;
            border-radius: 1.5rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .12);
            box-shadow: 0 28px 80px rgba(0, 0, 0, .34);
            background: linear-gradient(145deg, rgba(155, 216, 228, .1), rgba(255, 255, 255, .02));
            position: relative;
        }
        .profile-frame img { width: 100%; height: 100%; object-fit: cover; }
        .profile-caption {
            position: absolute;
            inset-inline: 0;
            bottom: 0;
            padding: 1.25rem;
            background: linear-gradient(to top, rgba(0, 0, 0, .65), transparent);
            color: #fff;
        }
        .profile-placeholder {
            width: 100%; height: 100%;
            display: grid; place-items: center;
            color: #d7f8fd;
            font-size: clamp(4rem, 11vw, 7rem);
            font-weight: 800;
        }
        .card-clean {
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: rgba(255, 255, 255, .045);
            color: var(--ink);
            box-shadow: 0 18px 44px rgba(0, 0, 0, .16);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        body.theme-light .card-clean {
            background: #fff;
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
        }
        .card-clean:not(form):hover {
            transform: translateY(-3px);
            border-color: rgba(155, 216, 228, .24);
            box-shadow: 0 26px 60px rgba(0, 0, 0, .24);
        }
        .icon-box {
            width: 42px; height: 42px;
            display: inline-grid; place-items: center;
            border-radius: .85rem;
            color: var(--brand-300);
            background: rgba(155, 216, 228, .09);
        }
        .timeline {
            border-left: 2px solid var(--line);
            padding-left: 24px;
        }
        .timeline-item { position: relative; padding-bottom: 24px; }
        .timeline-item::before {
            content: "";
            position: absolute;
            width: 12px; height: 12px;
            border-radius: 999px;
            background: var(--brand-500);
            left: -31px;
            top: 6px;
        }
        .portfolio-card img, .blog-card img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            background: #dfe8f2;
        }
        .media-placeholder {
            aspect-ratio: 16 / 10;
            display: grid;
            place-items: center;
            background: rgba(155, 216, 228, .08);
            color: var(--brand-300);
            font-weight: 700;
        }
        .table {
            --bs-table-color: var(--ink);
            --bs-table-bg: transparent;
            --bs-table-border-color: rgba(255, 255, 255, .08);
        }
        body.theme-light .table {
            --bs-table-border-color: rgba(15, 23, 42, .08);
        }
        .table-light {
            --bs-table-color: var(--ink);
            --bs-table-bg: rgba(255, 255, 255, .06);
        }
        body.theme-light .table-light {
            --bs-table-bg: var(--brand-50);
        }
        .form-control,
        .form-select {
            color: var(--ink);
            background-color: rgba(255, 255, 255, .05);
            border-color: rgba(255, 255, 255, .12);
        }
        body.theme-light .form-control,
        body.theme-light .form-select {
            background-color: #fff;
            border-color: rgba(15, 23, 42, .14);
        }
        .form-control:focus,
        .form-select:focus {
            color: var(--ink);
            background-color: rgba(255, 255, 255, .07);
            border-color: var(--brand-300);
            box-shadow: 0 0 0 .25rem rgba(155, 216, 228, .15);
        }
        .form-control::placeholder { color: rgba(226, 232, 240, .45); }
        body.theme-light .form-control::placeholder { color: rgba(15, 23, 42, .42); }
        .progress {
            height: .55rem;
            background: rgba(255, 255, 255, .08);
        }
        .progress-bar { background: var(--brand-500) !important; }
        .cta-panel {
            border-radius: 1.5rem;
            background: linear-gradient(135deg, var(--brand-700), var(--brand-900));
            color: #fff;
            overflow: hidden;
            position: relative;
        }
        .cta-panel::after {
            content: "";
            position: absolute;
            width: 22rem;
            height: 22rem;
            right: -9rem;
            bottom: -10rem;
            border-radius: 999px;
            background: rgba(200, 162, 74, .18);
            filter: blur(24px);
        }
        .footer {
            background: #08111f;
            color: rgba(255,255,255,.72);
            border-top: 1px solid rgba(255, 255, 255, .08);
        }
        .footer a { color: #aef5ff; text-decoration: none; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal { animation: fadeUp .7s ease-out both; }
        .reveal-delay-1 { animation-delay: .1s; }
        .reveal-delay-2 { animation-delay: .2s; }
        @media (prefers-reduced-motion: reduce) {
            .reveal { animation: none; }
            html { scroll-behavior: auto; }
        }
        @media (max-width: 991px) {
            .navbar-collapse {
                margin-top: 1rem;
                padding: .75rem 0;
                border-top: 1px solid rgba(255, 255, 255, .08);
            }
            body.theme-light .navbar-collapse {
                border-top-color: rgba(15, 23, 42, .08);
            }
            .hero { padding-top: 48px; }
        }
    </style>
    @stack('styles')
</head>
<body data-bs-spy="scroll" data-bs-target="#publicNavbar" data-bs-offset="84" tabindex="0">
    @php($targetLocale = app()->getLocale() === 'id' ? 'en' : 'id')
    <nav id="publicNavbar" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-inline-flex align-items-center gap-2" href="{{ route('home') }}">
                @if(! empty($setting?->logo))
                    <img src="{{ asset('storage/'.$setting->logo) }}" alt="{{ $setting->site_name }}" height="32" class="me-2">
                @else
                    <span class="brand-mark">JA</span>
                @endif
                {{ $setting->site_name ?? 'Jauari Akhmad' }}
            </a>
            <div class="d-flex align-items-center gap-2 order-lg-2">
                <a class="language-toggle" href="{{ request()->fullUrlWithQuery(['lang' => $targetLocale]) }}" aria-label="{{ __('site.nav.switch_language') }}">
                    {{ strtoupper($targetLocale) }}
                </a>
                <button class="theme-toggle" type="button" aria-label="{{ __('site.nav.toggle_theme') }}" data-theme-toggle>
                    <i class="bi bi-sun"></i>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="{{ __('site.nav.toggle_navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div id="mainNav" class="collapse navbar-collapse order-lg-1">
                <ul class="navbar-nav ms-auto gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#home">{{ __('site.nav.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">{{ __('site.nav.about') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#services">{{ __('site.nav.expertise') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#experience">{{ __('site.nav.experience') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#portfolio">{{ __('site.nav.works') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('publications.index') }}">{{ __('site.nav.publications') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#teaching">{{ __('site.nav.teaching') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">{{ __('site.nav.contact') }}</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} {{ $setting->site_name ?? 'Jauari Akhmad Nur Hasim' }}.</span>
            <span>{{ $profile->professional_title ?? 'Lecturer, Software Engineer' }}</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const button = document.querySelector('[data-theme-toggle]');
            const stored = localStorage.getItem('jauari-theme');

            if (stored === 'light') {
                document.body.classList.add('theme-light');
            }

            const syncIcon = () => {
                if (button) {
                    button.innerHTML = document.body.classList.contains('theme-light')
                        ? '<i class="bi bi-moon"></i>'
                        : '<i class="bi bi-sun"></i>';
                }
            };

            button?.addEventListener('click', () => {
                document.body.classList.toggle('theme-light');
                localStorage.setItem('jauari-theme', document.body.classList.contains('theme-light') ? 'light' : 'dark');
                syncIcon();
            });

            syncIcon();
        })();
    </script>
    @stack('scripts')
</body>
</html>
