@extends('layouts.app')

@section('title', 'Complaint List')

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
         <div class="card-header bg-light text-white">
                    <h3 class="card-title"><b>Daftar Keluhan</b></h3>
                  
                    <a href="{{ route('keluhan.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i>Tambah Keluhan
                    </a>
       
                </div>
       
        <div class="card-body">
            <div class="table-responsive">
                <table id="keluhanTable" class="table table-bordered table-hover table-striped">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                             <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Dari</th>
                            <th>Kepada</th>
                            <th>Jenis Permasalahan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->layanan->nama }}</td>
                            <td>{{ $item->dariPegawai->nama ?? '-' }}</td>
                            <td>{{ $item->kepadaPegawai->nama ?? '-' }}</td>
                            <td>{{ $item->jenis_permasalahan }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                <a href="{{ route('keluhan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('keluhan.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" " class="btn btn-sm btn-danger btn-hapus">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#keluhanTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries per page",
                zeroRecords: "No matching records found",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No complaints available",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
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
