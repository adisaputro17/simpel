@extends('layouts.app')

@section('title', 'Edit Pegawai')
@push('styles')
<style>
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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Edit Pegawai</h3>
                </div>

                <form method="POST" action="{{ route('pegawai.update', $pegawai->nip) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="{{ $pegawai->nama }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password">Password
                                <small class="text-muted">(Kosongkan jika tidak diganti)</small>
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="atasan_id">Atasan</label>
                            <select
                                name="atasan_id"
                                id="atasan_id"
                                class="form-control select2"
                            >
                                <option value="">-- Pilih Atasan --</option>
                                @foreach($atasans as $a)
                                    <option value="{{ $a->nip }}" {{ (isset($pegawai) && $pegawai->atasan_id == $a->nip) ? 'selected' : '' }}>
                                        {{ $a->nama }} ({{ $a->nip }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#atasan_id').select2({
            placeholder: "-- Pilih Atasan --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
