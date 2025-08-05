@extends('layouts.app')

@section('title', 'Input Penilaian Penampilan Harian')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mt-3">
                <div class="card-header">
                    <h3 class="card-title">Input Penilaian Penampilan Harian</h3>
                </div>

                <form action="{{ route('penampilan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-4">
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm">
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
                                                    <option value="100">Lengkap (100)</option>
                                                    <option value="75">Kurang 1 Atribut (75)</option>
                                                    <option value="50">Kurang 2 Atribut (50)</option>
                                                    <option value="25">Kurang 3 Atribut (25)</option>
                                                    <option value="0">Tidak Lengkap (0)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="penilaian[{{ $p->nip }}][seragam_sesuai_jadwal]" class="form-control">
                                                    <option value="100">Sesuai Jadwal (100)</option>
                                                    <option value="0">Tidak Sesuai Jadwal (0)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="penilaian[{{ $p->nip }}][seragam_sesuai_aturan]" class="form-control">
                                                    <option value="100">Sesuai Aturan (100)</option>
                                                    <option value="0">Tidak Sesuai Aturan (0)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="penilaian[{{ $p->nip }}][rapi]" class="form-control">
                                                    <option value="100">Rapi (100)</option>
                                                    <option value="0">Tidak Rapi (0)</option>
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
