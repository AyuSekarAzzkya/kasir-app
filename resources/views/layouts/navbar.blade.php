<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">

        <div class="navbar-text me-auto d-flex align-items-center">
            <i class="bi bi-calendar-event me-3"></i>
            <span id="currentDate" class="fw-bold text-secondary"></span>
        </div>

        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"></nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown"
                    href="#">
                    <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light">
                        <i class="bi bi-person-circle fs-4 text-secondary"></i>
                    </div>
                    <span class="profile-username ms-2">
                        <span class="op-7 text-secondary">Hi,</span>
                        <span class="fw-bold">{{ Auth::user()->name }}</span> {{-- Nama user --}}
                        <span class="badge bg-primary ms-1">{{ Auth::user()->role }}</span> {{-- Role --}}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn dropdown-menu-end shadow-lg border-0 rounded-3">
                    <li class="px-3 py-2">
                        <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{-- Tombol Logout --}}
                    <li class="text-center px-3 pb-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
@push('scripts')
    <script>
        function updateDate() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('currentDate').innerText = now.toLocaleDateString('id-ID', options);
        }
        updateDate();
        setInterval(updateDate, 60 * 1000);
    </script>
@endpush
