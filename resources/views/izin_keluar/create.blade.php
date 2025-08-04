@extends('layouts.app')

@section('title', 'Tambah Izin Keluar')
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
 
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Tambah Izin Keluar</h3>
                </div>

                <form method="POST" action="{{ route('izin_keluar.store') }}">
                    @csrf
                    <div class="card-body">
                        @include('izin_keluar.form')
                    </div>
                    <div class="card-footer text-right">
                         <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('izin_keluar.index') }}" class="btn btn-secondary">
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
            $('#nip').select2({
                placeholder: "-- Pilih Pegawai --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
