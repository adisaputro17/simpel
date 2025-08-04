<div class="form-group">
    <label for="nip">Pegawai</label>
    <select name="nip" id="nip" class="form-control select2" required>
        <option value="">-- Pilih Pegawai --</option>
        @foreach($bawahan as $b)
            <option value="{{ $b->nip }}" {{ old('nip', $izinKeluar->nip ?? '') == $b->nip ? 'selected' : '' }}>
                {{ $b->nama }} ({{ $b->nip }})
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="tanggal">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $izinKeluar->tanggal ?? '') }}" required>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="jam_keluar">Jam Keluar</label>
        <input type="time" name="jam_keluar" id="jam_keluar" class="form-control"
               value="{{ old('jam_keluar', $izinKeluar->jam_keluar ?? '') }}" required>
    </div>

    <div class="form-group col-md-6">
        <label for="jam_kembali">Jam Kembali</label>
        <input type="time" name="jam_kembali" id="jam_kembali" class="form-control"
               value="{{ old('jam_kembali', $izinKeluar->jam_kembali ?? '') }}" required>
    </div>
</div>


<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $izinKeluar->keterangan ?? '') }}</textarea>
</div>
