<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="fas fa-user-shield ml-3"></i>
        <span class="brand-text font-weight-light ml-2">SIMPEL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Pegawai -->
                <li class="nav-item">
                    <a href="{{ route('pegawai.index') }}" class="nav-link {{ request()->is('pegawai*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Pegawai</p>
                    </a>
                </li>

                <!-- Izin Keluar -->
                <li class="nav-item">
                    <a href="{{ route('izin_keluar.index') }}" class="nav-link {{ request()->is('izin_keluar*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>Izin Keluar</p>
                    </a>
                </li>

                <!-- Tugas Tambahan -->
                <li class="nav-item">
                    <a href="{{ route('tugas_tambahan.index') }}" class="nav-link {{ request()->is('tugas_tambahan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas Tambahan</p>
                    </a>
                </li>

                <!-- Penilaian -->
                <li class="nav-item has-treeview {{ request()->is('penilaian/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('penilaian/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Penilaian
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('penilaian.index', 'inovasi') }}" class="nav-link {{ request()->is('penilaian/inovasi*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inovasi </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penilaian.index', 'kerja_sama')}}" class="nav-link {{ request()->is('penilaian/kerja_sama*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kerja Sama </p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('penilaian.index', 'objektif')}}" class="nav-link {{ request()->is('penilaian/objectif*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Objectif</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                  <li class="nav-item">
                    <a href="{{ route('penampilan.index') }}" class="nav-link {{ request()->is('penampilan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Penampilan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('layanan.index') }}" class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Layanan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('keluhan.index') }}" class="nav-link {{ request()->is('keluhan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Keluhan</p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>
</aside>
