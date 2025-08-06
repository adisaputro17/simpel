@extends('layouts.app')

@section('title', 'Inovasi')
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

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Penilaian Inovasi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('penilaian.store', 'inovasi') }}">
                        @csrf
                        @include('penilaian.inovasi.form')
                         <div class="card-footer text-right">
                            <a href="{{ route('penilaian.index', 'inovasi') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>

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
            $('#nip').select2({
                placeholder: "-- Pilih Pegawai --",
                allowClear: true,
                width: '100%'
            });

            
            $('#bulan').select2({
                placeholder: "-- Pilih Bulan --",
                allowClear: true,
                width: '100%'
            });

             $('#nilai').select2({
                placeholder: "-- Pilih Nilai --",
                allowClear: true,
                width: '100%'
            });
        });

        
    </script>
@endpush
