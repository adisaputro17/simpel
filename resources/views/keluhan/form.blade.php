<div class="row">
    <div class="col-md-4 mb-3">
        <label><i class="far fa-calendar-alt"></i> Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', $item->tanggal ?? '') }}" class="form-control" required>
    </div>

<div class="col-md-4 mb-3">
    <label><i class="far fa-calendar"></i> Bulan</label>
    <select name="bulan" class="form-control" required>
        <option value="">Pilih Bulan</option>
        @foreach ([
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ] as $angka => $nama)
            <option value="{{ $angka }}" {{ old('bulan', $item->bulan ?? '') == $angka ? 'selected' : '' }}>
                {{ $nama }}
            </option>
        @endforeach
    </select>
</div>



    @php
    $tahunSekarang = date('Y');
@endphp

<div class="col-md-4 mb-3">
    <label><i class="fas fa-calendar-alt"></i> Tahun</label>
    <select name="tahun" class="form-control" required>
        <option value="">Pilih Tahun</option>
        @for ($tahun = $tahunSekarang - 5; $tahun <= $tahunSekarang + 5; $tahun++)
            <option value="{{ $tahun }}" {{ old('tahun', $item->tahun ?? '') == $tahun ? 'selected' : '' }}>
                {{ $tahun }}
            </option>
        @endfor
    </select>
</div>

    <div class="col-md-6 mb-3">
        <label><i class="fas fa-stream"></i> Jenis Layanan</label>
        <select name="jenis_layanan" class="form-control" required>
            <option value="internal" {{ old('jenis_layanan', $item->jenis_layanan ?? '') == 'internal' ? 'selected' : '' }}>Internal</option>
            <option value="eksternal" {{ old('jenis_layanan', $item->jenis_layanan ?? '') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label><i class="fas fa-concierge-bell"></i> Layanan</label>
        <select name="layanan_id" class="form-control" required>
            @foreach ($layanans as $layanan)
                <option value="{{ $layanan->id }}" {{ old('layanan_id', $item->layanan_id ?? '') == $layanan->id ? 'selected' : '' }}>
                    {{ $layanan->nama }}
                </option>
            @endforeach
        </select>
    </div>

 <div class="col-md-6 mb-3">
    <label><i class="fas fa-user"></i> Dari</label>
    <select name="dari" class="form-control select2">
        <option value="">-</option>
        @foreach ($pegawais as $pegawai)
            <option value="{{ $pegawai->nip }}" {{ old('dari', $item->dari ?? '') == $pegawai->nip ? 'selected' : '' }}>
                {{ $pegawai->nama }} ({{ $pegawai->nip}})
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-6 mb-3">
    <label><i class="fas fa-user-check"></i> Kepada</label>
    <select name="kepada" class="form-control select2" required>
        <option value="">-</option>
        @foreach ($pegawais as $pegawai)
            <option value="{{ $pegawai->nip }}" {{ old('kepada', $item->kepada ?? '') == $pegawai->nip ? 'selected' : '' }}>
                {{ $pegawai->nama }} ({{ $pegawai->nip}})
            </option>
        @endforeach
    </select>
</div>

    <div class="col-md-6 mb-3">
        <label><i class="fas fa-exclamation-circle"></i> Jenis Permasalahan</label>
        <select name="jenis_permasalahan" class="form-control" required>
            <option value="internal" {{ old('jenis_permasalahan', $item->jenis_permasalahan ?? '') == 'internal' ? 'selected' : '' }}>Internal</option>
            <option value="eksternal" {{ old('jenis_permasalahan', $item->jenis_permasalahan ?? '') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label><i class="fas fa-align-left"></i> Penjelasan Keluhan</label>
        <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
    </div>
</div>
