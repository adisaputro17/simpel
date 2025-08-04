@extends('layouts.app')

@section('title', 'Data Penampilan Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light text-white">
                    <h4 class="card-title mb-0"><strong>Data Penampilan Harian</strong></h4>
                    @if(auth('pegawai')->user()->bawahan->count() > 0)
                    <a href="{{ route('penampilan.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i>  Input Penilaian
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

                    <div class="table-responsive">
                        <table id="penampilanTable" class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>NIP</th>
                                    <th>Atribut Lengkap</th>
                                    <th>Seragam Sesuai Jadwal</th>
                                    <th>Seragam Sesuai Aturan</th>
                                    <th>Rapi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $d)
                                    <tr>
                                        <td>{{ $d->tanggal }}</td>
                                        <td>{{ $d->nip }}</td>
                                        <td>{{ $d->atribut_lengkap }}</td>
                                        <td>{{ $d->seragam_sesuai_jadwal }}</td>
                                        <td>{{ $d->seragam_sesuai_aturan }}</td>
                                        <td>{{ $d->rapi }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
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
                search: "Search:",
                lengthMenu: "Show  _MENU_ entries",
                zeroRecords: "Tidak Ada Data di Temukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total entri)"
            }
        });
        
    });
</script>
@endpush
