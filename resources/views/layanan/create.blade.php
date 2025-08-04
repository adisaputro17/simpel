@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Layanan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('layanan.store') }}">
                        @include('layanan.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
