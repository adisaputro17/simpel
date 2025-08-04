@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0 text-dark">Dashboard</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Info Box: Jumlah Pegawai -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalPegawai ?? 0 }}</h3>
                        <p>Total Pegawai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('pegawai.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Info Box: Jumlah Izin -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalIzin ?? 0 }}</h3>
                        <p>Izin Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <a href="{{ route('izin_keluar.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Info Box: Jumlah Tugas Tambahan -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalTugas ?? 0 }}</h3>
                        <p>Tugas Tambahan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <a href="{{ route('tugas_tambahan.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
