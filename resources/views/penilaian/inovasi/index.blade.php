@extends('layouts.app')

@section('title', 'Data Penilaian Inovasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light text-white">
                    <h4 class="card-title mb-0"><strong>Data Penilaian Inovasi</strong></h4>
                    @if(auth('pegawai')->user()->bawahan->count() > 0)
                        <a href="{{ route('penilaian.create', 'inovasi') }}" class="btn btn-primary btn-sm float-right" style="color: white !important;">
                            <i class="fas fa-plus-circle"></i> Tambah
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

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="penilaianTable" class="table table-bordered table-hover table-striped">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->pegawai->nama }}</td>
                                        @php
                                            $deskripsiNilai = [
                                                25 => 'Kurang Baik',
                                                50 => 'Cukup Baik',
                                                75 => 'Baik',
                                                100 => 'Sangat Baik',
                                            ];
                                        @endphp
                                        <td>{{ $item->nilai }} ({{ $deskripsiNilai[$item->nilai] ?? 'Tidak Diketahui' }})</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('m', $item->bulan)->translatedFormat('F') }}</td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td class="text-center">
                                            @if(auth('pegawai')->user()->bawahan->contains('nip', $item->nip))
                                                <a href="{{ route('penilaian.edit', ['inovasi', $item->id]) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('penilaian.destroy', ['inovasi', $item->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-hapus">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge badge-secondary">Read Only</span>
                                            @endif
                                        </td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#penilaianTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Belum ada data penilaian inovasi",
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

            $('.btn-hapus').on('click', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
