@extends('layouts.app')

@section('title', 'Inovasi')
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
