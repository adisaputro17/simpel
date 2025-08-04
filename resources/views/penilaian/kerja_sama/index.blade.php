@extends('layouts.app')

@section('title', 'Kerja Sama')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-header bg-light text-white">
                       <h3 class="card-title"><b>Penilaian Kerja Sama</b></h3>
                 
                       <a href="{{ route('penilaian.create', 'kerja_sama') }}" class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> Tambah 
                        </a>
                 
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="penilaianTable" class="table table-bordered table-hover table-striped">
                          <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th>NIP</th>
                                    <th>Nilai</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                           <tbody>
                        @foreach($data as $item)
                            <tr>
                                          <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nilai }}</td>
                                        <td>{{ $item->bulan }}</td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('penilaian.edit', ['kerja_sama', $item->id]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('penilaian.destroy', ['kerja_sama', $item->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-hapus">
                                            <i class="fas fa-trash"></i> Hapus
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
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
       $('#penilaianTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "Tidak ditemukan data yang cocok",
                info: " Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Next",
                    previous: "Back"
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
