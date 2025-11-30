<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a class="logo">
                <img src="{{ asset('template') }}/assets/img/kaiadmin/kasirku.png" alt="navbar brand"
                    class="navbar-brand" height="100"/>
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>

            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.index') }}"
                            class="{{ Request::routeIs('admin.dashboard.index') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <hr>

                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}"
                            class="{{ Request::routeIs('admin.user.index') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <p>Data Kasir</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.admin') }}" class="{{ Request::routeIs('user.admin') ? 'active' : '' }}">
                            <i class="fas fa-user-shield"></i>
                            <p>Data Admin</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                            class="{{ Request::routeIs('admin.categories.index') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <p>Kategori</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.product.index') }}"
                            class="{{ Request::routeIs('admin.product.index') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <p>Produk</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.report.index') }}"
                            class="{{ Request::routeIs('admin.report.index') ? 'active' : '' }}">
                            <i class="bi bi-journal-text"></i>
                            <p>Laporan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.stock.index') }}"
                            class="{{ Request::routeIs('admin.stock.index') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <p>Stock</p>
                        </a>
                    </li>
                @endrole

                @role('cashier')
                    <li class="nav-item">
                        <a href="{{ route('transaction.index') }}"
                            class="{{ Request::routeIs('transaction.index') ? 'active' : '' }}">
                            <i class="bi bi-cash"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('transactions.history') }}"
                            class="{{ Request::routeIs('transactions.history') ? 'active' : '' }}">
                            <i class="bi bi-clock-history"></i>
                            <p>Riwayat Transaksi</p>
                        </a>
                    </li>
                @endrole

            </ul>
        </div>
    </div>
</div>
