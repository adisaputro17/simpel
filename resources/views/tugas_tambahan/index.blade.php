@extends('layouts.app')

@section('title', 'Daftar Tugas Tambahan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-header bg-light text-white">
                    <h3 class="card-title"><b>Daftar Tugas Tambahan</b></h3>
                     @if(auth('pegawai')->user()->bawahan->count() > 0)
                    <a href="{{ route('tugas_tambahan.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i>Tambah Tugas
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
                        <table id="tugasTable" class="table table-bordered table-hover">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->pegawai->nama ?? '-' }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->jam_mulai }}</td>
                                        <td>{{ $item->jam_selesai }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td class="text-center">
                                            @if(auth('pegawai')->user()->bawahan->contains('nip', $item->nip))
                                                <a href="{{ route('tugas_tambahan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('tugas_tambahan.destroy', $item->id) }}" class="d-inline form-hapus">
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

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#tugasTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "Belum ada data tugas tambahan",
                info: " Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: " 0 to 0 of 0 entries",
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
