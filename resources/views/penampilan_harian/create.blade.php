@extends('layouts.app')

@section('title', 'Input Penampilan Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Input Penampilan Harian</h3>
                </div>

                <form action="{{ route('penampilan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-4">
                                <input type="date" name="tanggal" class="form-control" required
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                             <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Atribut Lengkap</th>
                                        <th>Seragam Sesuai Jadwal</th>
                                        <th>Seragam Sesuai Aturan</th>
                                        <th>Rapi</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pegawai as $p)
                                    <tr>
                                        <td>{{ $p->nip }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>
                                            <select name="penilaian[{{ $p->nip }}][atribut_lengkap]" class="form-control">
                                                @foreach([0, 25, 50, 75, 100] as $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="penilaian[{{ $p->nip }}][seragam_sesuai_jadwal]" class="form-control">
                                                <option value="0">0</option>
                                                <option value="100">100</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="penilaian[{{ $p->nip }}][seragam_sesuai_aturan]" class="form-control">
                                                <option value="0">0</option>
                                                <option value="100">100</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="penilaian[{{ $p->nip }}][rapi]" class="form-control">
                                                <option value="0">0</option>
                                                <option value="100">100</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="penilaian[{{ $p->nip }}][keterangan]" class="form-control">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
