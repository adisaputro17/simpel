@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
           <div class="card-header bg-light text-white">
                    <h4 class="card-title mb-0"><strong>Data Pegawai</strong></h4>
                    @if(auth('pegawai')->user()->bawahan->count() > 0)
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i>Tambah Pegawai
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
                        <table id="pegawaiTable" class="table table-bordered table-hover">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th style="width: 1%;">NO</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Atasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse($pegawais as $index => $p)
                                    <tr> 
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nip }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->atasan->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('pegawai.edit', $p->nip) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('pegawai.destroy', $p->nip) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                 <button type="submit" class="btn btn-sm btn-danger btn-hapus">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data pegawai</td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#pegawaiTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "Tidak ditemukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Data kosong",
                infoFiltered: "(disaring dari _MAX_ total data)"
            }
        });

            $('.btn-hapus').click(function (e) {
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
