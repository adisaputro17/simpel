@extends('layouts.app')
@section('title', 'Data Pegawai')
@push('styles')
<style>
/* Fix tampilan tinggi select2 agar mirip input Bootstrap */
.select2-container--default .select2-selection--single {
    height: 38px !important;
    padding: 6px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 24px;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pegawai</h3>
                </div>

                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                      <div class="form-group">
                            <label for="nip">NIP</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nip"
                                id="nip"
                                placeholder="Masukkan NIP"
                                pattern="\d{8,18}"
                                maxlength="30"
                                inputmode="numeric"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required>
                        </div>

                        <div class="form-group">
                            <label for="atasan_id">Atasan</label>
                            <select name="atasan_id" id="atasan_id" class="form-control select2" >
                                <option value="">-- Pilih Atasan --</option>
                                @foreach($atasans as $a)
                                    <option value="{{ $a->nip }}">{{ $a->nama }} ({{ $a->nip }})</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                     <div class="card-footer text-right">
                     
                         <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                           <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                   
                </form>

            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#atasan_id').select2({
                placeholder: "-- Pilih Atasan --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
