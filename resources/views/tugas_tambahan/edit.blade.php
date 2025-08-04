@extends('layouts.app')

@section('title', 'Edit Tugas Tambahan | SIMPEL')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Tugas Tambahan</h3>
                </div>

                <form method="POST" action="{{ route('tugas_tambahan.update', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('tugas_tambahan.form')
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('tugas_tambahan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update 
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
