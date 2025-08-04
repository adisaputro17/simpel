@extends('layouts.app')

@section('title', 'Kerja Sama')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Edit Penilaian Kerja Sama</h4>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('penilaian.update', ['kerja_sama', $item->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('penilaian.kerja_sama.form')

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Perbarui
                            </button>
                            <a href="{{ route('penilaian.index', 'kerja_sama') }}" class="btn btn-secondary">
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
