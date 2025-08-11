@extends('layouts.app')

@section('title', 'Data Penampilan Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light text-white">
                    <h4 class="card-title mb-0"><strong>Data Penampilan Harian</strong></h4>
                    @if(auth('pegawai')->user()->bawahan->count() > 0)
                        <a href="{{ route('penampilan.create') }}" class="btn btn-primary btn-sm float-right" style="color: white !important;">
                            <i class="fas fa-plus-circle"></i> Input Penilaian
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <form method="GET" class="form-inline mb-3">
                        <label for="tanggal" class="mr-2">Filter Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control mr-2" value="{{ request('tanggal') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Tampilkan</button>
                    </form>

                    <div class="table-responsive table-sm">
                        <table id="penampilanTable" class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Atribut Lengkap</th>
                                    <th class="text-center">Seragam Sesuai Jadwal</th>
                                    <th class="text-center">Seragam Sesuai Aturan</th>
                                    <th class="text-center">Rapi</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $d->tanggal }}</td>
                                        <td>{{ $d->nip }}</td>
                                        <td>{{ $d->pegawai->nama }}</td>
                                        <td>{{ nilaiAtributLengkap($d->atribut_lengkap) }}</td>
                                        <td>{{ nilaiSeragamSesuaiJadwal($d->seragam_sesuai_jadwal) }}</td>
                                        <td>{{ nilaiSeragamSesuaiAturan($d->seragam_sesuai_aturan) }}</td>
                                        <td>{{ nilaiRapi($d->rapi) }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        $(document).ready(function () {
            $('#penampilanTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Belum ada data penampilan harian",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                }
            });
        });
    </script>
@endpush

@php
    function nilaiAtributLengkap($nilai) {
        if ($nilai == 0) return 'Tidak Lengkap';
        elseif ($nilai == 25) return 'Kurang 3 Atribut';
        elseif ($nilai == 50) return 'Kurang 2 Atribut';
        elseif ($nilai == 75) return 'Kurang 1 Atribut';
        else return 'Lengkap';
    }

    function nilaiSeragamSesuaiJadwal($nilai) {
        if ($nilai == 0) return 'Tidak Sesuai Jadwal';
        else return 'Sesuai Jadwal';
    }

    function nilaiSeragamSesuaiAturan($nilai) {
        if ($nilai == 0) return 'Tidak Sesuai Aturan';
        else return 'Sesuai Aturan';
    }

    function nilaiRapi($nilai) {
        if ($nilai == 0) return 'Tidak Rapi';
        else return 'Rapi';
    }
@endphp