@extends('layouts.app')

@section('title', 'Inovasi')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-dark">
                    <h4 class="mb-0">Edit Penilaian Inovasi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('penilaian.update', ['inovasi', $item->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('penilaian.inovasi.form')

                        <div class="card-footer text-right">
                               <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui
                            </button>

                            <a href="{{ route('penilaian.index', 'inovasi') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                         
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
