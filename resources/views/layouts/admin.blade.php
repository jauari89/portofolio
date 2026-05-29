<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') | Jauari Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.6.1/dist/css/coreui.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-sidebar: #212631;
            --admin-sidebar-soft: #2a303d;
            --admin-primary: #2563eb;
            --admin-primary-dark: #1d4ed8;
            --admin-line: #d8dbe0;
            --admin-body: #f3f4f7;
        }

        body {
            background: var(--admin-body);
            color: #1f2937;
            font-size: .94rem;
        }

        .admin-shell {
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 16rem;
            background: var(--admin-sidebar);
            color: rgba(255, 255, 255, .72);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: inset -1px 0 0 rgba(255, 255, 255, .06);
            z-index: 1035;
        }

        .brand-lockup {
            min-height: 4rem;
            color: #fff;
            background: rgba(0, 0, 0, .14);
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            text-decoration: none;
        }

        .brand-mark {
            width: 2.25rem;
            height: 2.25rem;
            display: inline-grid;
            place-items: center;
            border-radius: .5rem;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            font-weight: 800;
            color: #fff;
        }

        .sidebar-nav {
            padding: .75rem;
        }

        .sidebar-nav .nav-title {
            color: rgba(255, 255, 255, .38);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            padding: .75rem .75rem .35rem;
            text-transform: uppercase;
        }

        .sidebar-nav a {
            min-height: 2.65rem;
            color: rgba(255, 255, 255, .72);
            text-decoration: none;
            border-radius: .5rem;
            transition: background-color .16s ease, color .16s ease;
        }

        .sidebar-nav a i {
            width: 1.25rem;
            color: rgba(255, 255, 255, .56);
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: #fff;
            background: var(--admin-sidebar-soft);
        }

        .sidebar-nav a.active {
            box-shadow: inset 3px 0 0 #3b82f6;
        }

        .admin-wrapper {
            min-width: 0;
            flex: 1;
        }

        .admin-header {
            min-height: 4rem;
            background: rgba(255, 255, 255, .92);
            border-bottom: 1px solid var(--admin-line);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content {
            min-width: 0;
            flex: 1;
        }

        .card-clean {
            border: 1px solid var(--admin-line);
            border-radius: .5rem;
            box-shadow: 0 .75rem 2rem rgba(31, 41, 55, .05);
        }

        .table thead th {
            color: #667085;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .table > :not(caption) > * > * {
            padding: .9rem 1rem;
        }

        .btn-primary {
            --cui-btn-bg: var(--admin-primary);
            --cui-btn-border-color: var(--admin-primary);
            --cui-btn-hover-bg: var(--admin-primary-dark);
            --cui-btn-hover-border-color: var(--admin-primary-dark);
        }

        .form-control,
        .form-select {
            border-color: #d0d5dd;
        }

        .form-label { font-weight: 600; }

        .admin-footer {
            border-top: 1px solid var(--admin-line);
            color: #667085;
            background: #fff;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                position: fixed;
                left: -16rem;
                transition: left .2s ease;
            }

            body.sidebar-show .admin-sidebar {
                left: 0;
            }

            body.sidebar-show .sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1030;
                background: rgba(15, 23, 42, .48);
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-backdrop" data-sidebar-close></div>
    <div class="admin-shell d-flex">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand-lockup d-flex align-items-center gap-2 px-3">
                <span class="brand-mark">JA</span>
                <span class="fw-bold">Jauari Admin</span>
            </a>
            @php
                $navGroups = [
                    'Overview' => [
                        ['label' => 'Dashboard', 'icon' => 'bi bi-speedometer2', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
                        ['label' => 'Preview Site', 'icon' => 'bi bi-box-arrow-up-right', 'route' => 'home', 'match' => 'never'],
                    ],
                    'Content' => [
                        ['label' => 'Profile', 'icon' => 'bi bi-person', 'route' => 'admin.profile.edit', 'match' => 'admin.profile.*'],
                        ['label' => 'About', 'icon' => 'bi bi-info-circle', 'route' => 'admin.about.edit', 'match' => 'admin.about.*'],
                        ['label' => 'Hero', 'icon' => 'bi bi-stars', 'route' => 'admin.hero.edit', 'match' => 'admin.hero.*'],
                        ['label' => 'Stats', 'icon' => 'bi bi-bar-chart', 'route' => 'admin.stats.index', 'match' => 'admin.stats.*'],
                        ['label' => 'Academic Metrics', 'icon' => 'bi bi-mortarboard', 'route' => 'admin.academic-metrics.index', 'match' => 'admin.academic-metrics.*'],
                        ['label' => 'Skills', 'icon' => 'bi bi-tools', 'route' => 'admin.skills.index', 'match' => 'admin.skills.*'],
                        ['label' => 'Services', 'icon' => 'bi bi-grid', 'route' => 'admin.services.index', 'match' => 'admin.services.*'],
                        ['label' => 'Experiences', 'icon' => 'bi bi-mortarboard', 'route' => 'admin.experiences.index', 'match' => 'admin.experiences.*'],
                    ],
                    'Publishing' => [
                        ['label' => 'Portfolios', 'icon' => 'bi bi-kanban', 'route' => 'admin.portfolios.index', 'match' => 'admin.portfolios.*'],
                        ['label' => 'Publications', 'icon' => 'bi bi-journal-text', 'route' => 'admin.publications.index', 'match' => 'admin.publications.*'],
                        ['label' => 'Teaching', 'icon' => 'bi bi-easel', 'route' => 'admin.teaching.index', 'match' => 'admin.teaching.*'],
                        ['label' => 'Teaching Materials', 'icon' => 'bi bi-file-earmark-pdf', 'route' => 'admin.teaching-materials.index', 'match' => 'admin.teaching-materials.*'],
                        ['label' => 'Supervisions', 'icon' => 'bi bi-people', 'route' => 'admin.supervisions.index', 'match' => 'admin.supervisions.*'],
                        ['label' => 'Blog', 'icon' => 'bi bi-pencil-square', 'route' => 'admin.blog.index', 'match' => 'admin.blog.*'],
                    ],
                    'System' => [
                        ['label' => 'Messages', 'icon' => 'bi bi-envelope', 'route' => 'admin.contact-messages.index', 'match' => 'admin.contact-messages.*'],
                        ['label' => 'Settings', 'icon' => 'bi bi-sliders', 'route' => 'admin.settings.edit', 'match' => 'admin.settings.*'],
                        ['label' => 'Social Links', 'icon' => 'bi bi-share', 'route' => 'admin.social-links.index', 'match' => 'admin.social-links.*'],
                    ],
                ];
            @endphp
            <nav class="sidebar-nav d-grid gap-1">
                @foreach($navGroups as $group => $items)
                    <div class="nav-title">{{ $group }}</div>
                    @foreach($items as $item)
                        <a href="{{ route($item['route']) }}" class="d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs($item['match']) ? 'active' : '' }}" @if($item['route'] === 'home') target="_blank" rel="noopener" @endif>
                            <i class="{{ $item['icon'] }}"></i><span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                @endforeach
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-2 px-0">
                    @csrf
                    <button class="btn btn-outline-light w-100 text-start" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            </nav>
        </aside>

        <div class="admin-wrapper d-flex flex-column">
            <header class="admin-header d-flex align-items-center justify-content-between px-3 px-lg-4">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-ghost-dark d-lg-none" type="button" data-sidebar-toggle aria-label="Open navigation">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <div>
                        <div class="small text-body-secondary">Portfolio CMS</div>
                        <strong>@yield('title', 'Admin Panel')</strong>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-arrow-up-right me-1"></i>Preview
                    </a>
                    <span class="d-none d-md-inline small text-body-secondary">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </header>

            <main class="content p-3 p-lg-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>

            <footer class="admin-footer px-3 px-lg-4 py-3 small">
                Jauari Portfolio Admin - CoreUI-inspired Blade interface
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.6.1/dist/js/coreui.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
            button.addEventListener('click', () => document.body.classList.add('sidebar-show'));
        });

        document.querySelectorAll('[data-sidebar-close], .sidebar-nav a').forEach((element) => {
            element.addEventListener('click', () => document.body.classList.remove('sidebar-show'));
        });
    </script>
</body>
</html>
