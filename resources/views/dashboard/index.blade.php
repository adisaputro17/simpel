@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">

        <!-- Info Boxes -->
        <div class="row mb-4">
            <!-- Total Pegawai -->
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

            <!-- Total Izin -->
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

            <!-- Total Tugas Tambahan -->
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

        <!-- Tabel Nilai Pegawai -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-chart-bar"></i> Nilai Izin Keluar Pegawai</h4>
            </div>

            <div class="card-body">
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>Bulan Awal</label>
                            <select name="bulan_awal" class="form-control">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_awal') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Bulan Akhir</label>
                            <select name="bulan_akhir" class="form-control">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_akhir') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', now()->year) }}">
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <button class="btn btn-success btn-block">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="nilaiTable" class="table table-striped table-bordered">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Kehadiran</th>
                                <th>Kinerja</th>
                                <th>Kerja Sama</th>
                                <th>Inovasi</th>
                                <th>Penampilan</th>
                                <th>Komplain</th>
                                <th><b>Total</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $row['nip'] }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['total_nilai_kehadiran_bobot'] }}</td>
                                <td>{{ $row['total_nilai_kinerja_bobot'] }}</td>
                                <td>{{ $row['nilai_kerja_sama_bobot'] }}</td>
                                <td>{{ $row['nilai_inovasi_bobot'] }}</td>
                                <td>{{ $row['nilai_penampilan_bobot'] }}</td>
                                <td>{{ $row['nilai_komplain_bobot'] }}</td>
                                <td class="text-center"><b>{{ $row['total_nilai'] }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nilaiTable').DataTable({
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "Data tidak ditemukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });
    });
</script>
@endpush
