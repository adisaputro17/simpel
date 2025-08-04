@extends('layouts.app')

@section('title', 'Daftar Layanan')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
               <div class="card-header bg-light text-white">
                    <h4 class="card-title mb-0"><strong>Data Layanan</strong></h4>
                    @if(auth('pegawai')->user()->bawahan->count() > 0)
                    <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i>Tambah Layanan
                     </a>
                    @endif
                </div> 
             <div class="card-body">
            <div class="table-responsive">
                <table id="layananTable" class="table table-bordered table-striped table-hover">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            @for($i = 1; $i <= 12; $i++)
                                <th>B{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                            @endfor
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data ?? [] as $layanan)
                            <tr>
                                <td>{{ $layanan->nama }}</td>
                                <td>{{ ucfirst($layanan->jenis) }}</td>
                                <td class="text-center">{{ $layanan->tahun }}</td>
                                @for($i = 1; $i <= 12; $i++)
                                    @php $bulan = 'bulan_' . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                    <td class="text-center">{{ $layanan->$bulan ?? 0 }}</td>
                                @endfor
                                <td class="text-center">
                                    <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-hapus">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @for($i = 0; $i < 16; $i++)
                                    <td class="text-center text-muted font-italic">
                                        @if($i === 0)
                                            <i class="fas fa-info-circle"></i> Belum ada data layanan
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
            $('#layananTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Search:",
                    lengthMenu: "Show  _MENU_ entries",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    info: "Showing  _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                },
                columnDefs: [
                    { targets: '_all', defaultContent: '-' },
                    { targets: -1, orderable: false, searchable: false } // Kolom aksi tidak bisa dicari/urut
                ]
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
