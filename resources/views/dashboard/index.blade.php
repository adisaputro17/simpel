@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Rekap Nilai Pegawai</h4>
            </div>

            <div class="card-body">
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>Bulan Awal</label>
                            <select name="bulan_awal" class="form-control">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_awal', now()->month) == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Bulan Akhir</label>
                            <select name="bulan_akhir" class="form-control">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_akhir', now()->month) == $i ? 'selected' : '' }}>
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
                    <table class="table table-striped table-bordered table-sm" style="min-width: 3000px;">
                        <thead class="bg-light text-center">
                            <tr>
                                <th rowspan="2" class="text-center align-middle">No</th>
                                <th rowspan="2" class="text-center align-middle">NIP</th>
                                <th rowspan="2" class="text-center align-middle">Nama</th>
                                <th colspan="3" class="text-center align-middle">Kehadiran (20%)</th>
                                <th colspan="3" class="text-center align-middle">Kinerja (25%)</th>
                                <th rowspan="2" class="text-center align-middle">Kerja Sama (15%)</th>
                                <th rowspan="2" class="text-center align-middle">Inovasi (15%)</th>
                                <th colspan="4" class="text-center align-middle">Penampilan (10%)</th>
                                <th rowspan="2" class="text-center align-middle">Komplain (15%)</th>
                                <th rowspan="2" class="text-center align-middle">Total Nilai</th>
                                <th rowspan="2" class="text-center align-middle"><b>Total</b></th>
                            </tr>
                            <tr>
                                <th>Absensi (30%)</th>
                                <th>Apel Pagi (30%)</th>
                                <th>Izin Keluar (40%)</th>
                                <th>Kinerja (20%)</th>
                                <th>Objektif (45%)</th>
                                <th>Tugas Tambahan (35%)</th>
                                <th>Atribut Lengkap (25%)</th>
                                <th>Seragam Sesuai Jadwal (25%)</th>
                                <th>Seragam Sesuai Aturan (25%)</th>
                                <th>Rapi (25%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row['nip'] }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['nilai_absensi'] }} ( {{ $row['nilai_absensi_bobot'] }} )</td>
                                <td>{{ $row['nilai_apel'] }} ( {{ $row['nilai_apel_bobot'] }} )</td>
                                <td>{{ $row['nilai_izin_keluar'] }} ( {{ $row['nilai_izin_keluar_bobot'] }} )</td>
                                <td>{{ $row['nilai_kinerja'] }} ( {{ $row['nilai_kinerja_bobot'] }} )</td>
                                <td>{{ $row['nilai_objektif'] }} ( {{ $row['nilai_objektif_bobot'] }} )</td>
                                <td>{{ $row['nilai_tugas_tambahan'] }} ( {{ $row['nilai_tugas_tambahan_bobot'] }} )</td>
                                <td>{{ $row['nilai_kerja_sama'] }} ( {{ $row['nilai_kerja_sama_bobot'] }} )</td>
                                <td>{{ $row['nilai_inovasi'] }} ( {{ $row['nilai_inovasi_bobot'] }} )</td>
                                <td>{{ $row['nilai_atribut_lengkap'] }} ( {{ $row['nilai_atribut_lengkap_bobot'] }} )</td>
                                <td>{{ $row['nilai_seragam_sesuai_jadwal'] }} ( {{ $row['nilai_seragam_sesuai_jadwal_bobot'] }} )</td>
                                <td>{{ $row['nilai_seragam_sesuai_aturan'] }} ( {{ $row['nilai_seragam_sesuai_aturan_bobot'] }} )</td>
                                <td>{{ $row['nilai_rapi'] }} ( {{ $row['nilai_rapi_bobot'] }} )</td>
                                <td>{{ $row['nilai_komplain'] }} ( {{ $row['nilai_komplain_bobot'] }} )</td>
                                <td>{{ $row['total_nilai_kehadiran_bobot'] }} + {{ $row['total_nilai_kinerja_bobot'] }} + {{ $row['nilai_kerja_sama_bobot'] }} + {{ $row['nilai_inovasi_bobot'] }} + {{ $row['nilai_penampilan_bobot'] }} + {{ $row['nilai_komplain_bobot'] }}</td>
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