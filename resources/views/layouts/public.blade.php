<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $setting->site_title ?? 'Jauari Akhmad Nur Hasim')</title>
    <meta name="description" content="@yield('meta_description', $setting->meta_description ?? 'Portfolio profesional Jauari Akhmad Nur Hasim.')">
    <meta name="keywords" content="{{ $setting->meta_keywords ?? 'Jauari Akhmad, lecturer, software engineer, portfolio' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @if(! empty($setting?->favicon))
        <link rel="icon" href="{{ asset('storage/'.$setting->favicon) }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #0b1728;
            --navy: #10233f;
            --cyan: #0ea5b7;
            --muted: #637083;
            --line: #e6edf5;
            --surface: #f7fafc;
        }

        html { scroll-behavior: smooth; }
        body {
            color: var(--ink);
            background: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .navbar {
            border-bottom: 1px solid rgba(15, 35, 63, .08);
            backdrop-filter: blur(14px);
        }
        .nav-link { color: #24405f; font-weight: 600; font-size: .92rem; }
        .nav-link:hover, .nav-link.active { color: var(--cyan); }
        .btn-primary {
            --bs-btn-bg: var(--cyan);
            --bs-btn-border-color: var(--cyan);
            --bs-btn-hover-bg: #0a8998;
            --bs-btn-hover-border-color: #0a8998;
        }
        .btn-outline-primary {
            --bs-btn-color: var(--cyan);
            --bs-btn-border-color: var(--cyan);
            --bs-btn-hover-bg: var(--cyan);
            --bs-btn-hover-border-color: var(--cyan);
        }
        .section { padding: 88px 0; }
        .section-soft { background: var(--surface); }
        .section-title { max-width: 760px; margin-bottom: 36px; }
        .section-kicker {
            color: var(--cyan);
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .78rem;
        }
        .hero {
            min-height: calc(100vh - 64px);
            padding: 104px 0 72px;
            background:
                linear-gradient(110deg, rgba(11, 23, 40, .94), rgba(16, 35, 63, .9)),
                var(--hero-bg, none);
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .hero h1 { font-size: clamp(2.45rem, 5vw, 5.2rem); line-height: 1; letter-spacing: 0; }
        .hero-copy { color: rgba(255,255,255,.76); max-width: 680px; }
        .profile-frame {
            width: min(100%, 360px);
            aspect-ratio: 4 / 5;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 28px 80px rgba(0,0,0,.34);
            background: #123153;
        }
        .profile-frame img { width: 100%; height: 100%; object-fit: cover; }
        .profile-placeholder {
            width: 100%; height: 100%;
            display: grid; place-items: center;
            color: #d7f8fd;
            font-size: clamp(4rem, 11vw, 7rem);
            font-weight: 800;
        }
        .card-clean {
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 14px 38px rgba(16, 35, 63, .06);
        }
        .icon-box {
            width: 42px; height: 42px;
            display: inline-grid; place-items: center;
            border-radius: 8px;
            color: var(--cyan);
            background: #e9fbfd;
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
            background: var(--cyan);
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
            background: #dfe8f2;
            color: #49627d;
            font-weight: 700;
        }
        .footer { background: var(--ink); color: rgba(255,255,255,.72); }
        .footer a { color: #aef5ff; text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body data-bs-spy="scroll" data-bs-target="#publicNavbar" data-bs-offset="84" tabindex="0">
    <nav id="publicNavbar" class="navbar navbar-expand-lg bg-white bg-opacity-95 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="{{ route('home') }}">
                @if(! empty($setting?->logo))
                    <img src="{{ asset('storage/'.$setting->logo) }}" alt="{{ $setting->site_name }}" height="32" class="me-2">
                @endif
                {{ $setting->site_name ?? 'Jauari Akhmad' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="mainNav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#services">Expertise</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#experience">Experience</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#portfolio">Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('publications.index') }}">Publications</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#teaching">Teaching</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
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
    @stack('scripts')
</body>
</html>
