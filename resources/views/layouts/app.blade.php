<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Junior Gurukul School</title>
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bs-navy: #1B365D;
            --bs-navy-dark: #122442;
            --bs-primary-accent: #2563EB;
            --bs-gold: #D4AF37;
            --bs-body-bg: #F4F6F9;
            --bs-card-border-radius: 12px;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bs-body-bg);
            color: #334155;
            min-height: 100vh;
            display: flex;
        }

        .bg-navy { background-color: var(--bs-navy) !important; }
        .text-navy { color: var(--bs-navy) !important; }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: #FFFFFF;
            border-right: 1px solid #E2E8F0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .sidebar-menu {
            padding: 1rem 0.75rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .menu-header {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94A3B8;
            padding: 0.75rem 1rem 0.35rem;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 1rem;
            color: #475569;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link-custom i {
            font-size: 1.1rem;
            margin-right: 0.5rem;
            color: #64748B;
        }

        .nav-link-custom:hover {
            color: var(--bs-navy);
            background-color: #F8FAFC;
        }

        .nav-link-custom.active {
            color: #FFFFFF;
            background-color: var(--bs-navy);
            font-weight: 600;
        }

        .nav-link-custom.active i {
            color: #FFFFFF;
        }

        .main-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            height: 65px;
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .bg-soft-primary { background-color: #EFF6FF; color: #1D4ED8; }
        .bg-soft-success { background-color: #ECFDF5; color: #047857; }
        .bg-soft-danger { background-color: #FEF2F2; color: #B91C1C; }
        .bg-soft-warning { background-color: #FFFBEB; color: #B45309; }
        .bg-soft-info { background-color: #F0F9FF; color: #0369A1; }

        .btn-navy {
            background-color: var(--bs-navy);
            color: #FFFFFF;
        }
        .btn-navy:hover {
            background-color: var(--bs-navy-dark);
            color: #FFFFFF;
        }

        @media (max-width: 991.98px) {
            .sidebar { margin-left: -260px; }
            .sidebar.show { margin-left: 0; }
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar shadow-sm">
        <div class="sidebar-brand d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle text-navy d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-weight: 700; background: linear-gradient(145deg, #E4C185, #C5A059); color: #0B192C;">
                    JG
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.92rem;">Junior Gurukul</h6>
                    <span class="text-muted" style="font-size: 0.72rem;">School · Bhikangaon</span>
                </div>
            </div>
            <button class="btn btn-sm btn-light d-lg-none" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
        </div>

        @php
            $userRole = auth()->user()->role_name ?? 'school_admin';
            $isSuperAdmin = $userRole === 'super_admin';
            $isSchoolAdmin = $userRole === 'school_admin';
            $isAdmin = $isSuperAdmin || $isSchoolAdmin;
            $isTeacher = $userRole === 'teacher';
            $isStudent = $userRole === 'student';
            $isParent = $userRole === 'parent';
            $isAccountant = $userRole === 'accountant';
            $isLibrarian = $userRole === 'librarian';
            $isTransport = $userRole === 'transport_manager';
            $isHr = $userRole === 'hr_manager';
        @endphp

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>

            <div class="menu-header">Academics</div>
            <a href="{{ route('admin.students.index') }}" class="nav-link-custom {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> {{ ($isStudent || $isParent) ? 'My Profile & Directory' : 'Students Directory' }}
            </a>
            @if($isAdmin || $isHr)
            <a href="{{ route('admin.teachers.index') }}" class="nav-link-custom {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Teachers & Staff
            </a>
            @endif
            @if($isAdmin || $isTeacher)
            <a href="{{ route('admin.classes.index') }}" class="nav-link-custom {{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Classes & Sections
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="nav-link-custom {{ request()->routeIs('admin.subjects*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Subjects
            </a>
            @endif
            @if($isAdmin || $isTeacher || $isStudent || $isParent)
            <a href="{{ route('admin.timetable.index') }}" class="nav-link-custom {{ request()->routeIs('admin.timetable*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Timetable
            </a>
            @endif

            @if($isAdmin || $isTeacher || $isStudent || $isParent)
            <div class="menu-header">Attendance</div>
            <a href="{{ route('admin.attendance.index') }}" class="nav-link-custom {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i> {{ ($isAdmin || $isTeacher) ? 'Mark Attendance' : 'Attendance Records' }}
            </a>
            @endif

            @if($isAdmin || $isAccountant || $isStudent || $isParent)
            <div class="menu-header">Finance & Fees</div>
            <a href="{{ route('admin.fees.index') }}" class="nav-link-custom {{ request()->routeIs('admin.fees*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> {{ ($isAdmin || $isAccountant) ? 'Fee Management' : 'Fee Dues & Receipts' }}
            </a>
            @endif

            @if($isAdmin || $isTeacher || $isStudent || $isParent)
            <div class="menu-header">Examinations</div>
            <a href="{{ route('admin.exams.index') }}" class="nav-link-custom {{ request()->routeIs('admin.exams*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Exams & Marks
            </a>
            @endif

            <div class="menu-header">Communication</div>
            <a href="{{ route('admin.notices.index') }}" class="nav-link-custom {{ request()->routeIs('admin.notices*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> Notices & Events
            </a>
            @if($isAdmin || $isTeacher || $isStudent || $isParent)
            <a href="{{ route('admin.homework.index') }}" class="nav-link-custom {{ request()->routeIs('admin.homework*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Homework
            </a>
            @endif

            @if($isAdmin)
            <div class="menu-header">Admissions & CMS</div>
            <a href="{{ route('admin.admissions.index') }}" class="nav-link-custom {{ request()->routeIs('admin.admissions*') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Online Admissions
            </a>
            <a href="{{ route('admin.cms.index') }}" class="nav-link-custom {{ request()->routeIs('admin.cms*') ? 'active' : '' }}">
                <i class="bi bi-globe"></i> Website CMS
            </a>
            @endif

            @if($isSuperAdmin)
            <div class="menu-header">System</div>
            <a href="{{ route('admin.settings.index') }}" class="nav-link-custom {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Settings & Roles
            </a>
            @endif
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
                <div class="d-none d-md-flex align-items-center text-muted small">
                    <i class="bi bi-calendar-event me-2 text-primary"></i> Academic Year: <strong class="ms-1 text-dark">2026 - 2027</strong>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('website.home') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-up-right"></i> View Website
                </a>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border-0 bg-transparent py-1 px-2" type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-navy text-white fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.9rem;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                        </div>
                        <div class="text-start d-none d-md-block">
                            <div class="fw-semibold text-dark small leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ ucfirst(str_replace('_', ' ', auth()->user()->role_name ?? 'School Admin')) }}</div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2 mt-2">
                        <li><h6 class="dropdown-header text-uppercase small text-muted">Account</h6></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if(session('error'))
                <x-alert type="danger">{{ session('error') }}</x-alert>
            @endif

            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted small">
            <div>&copy; {{ date('Y') }} Junior Gurukul School, Bhikangaon — Powered by <strong>Enterprise School Management SaaS</strong></div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        document.getElementById('sidebarClose')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.remove('show');
        });
    </script>
    @stack('scripts')
</body>
</html>
