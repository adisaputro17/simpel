@csrf
@if(isset($layanan))
    @method('PUT')
@endif

<div class="form-group">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $layanan->nama ?? '') }}" required>
</div>

<div class="form-group">
    <label for="jenis">Jenis:</label>
    <select name="jenis" id="jenis" class="form-control" required>
        <option value="internal" {{ old('jenis', $layanan->jenis ?? '') == 'internal' ? 'selected' : '' }}>Internal</option>
        <option value="eksternal" {{ old('jenis', $layanan->jenis ?? '') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
    </select>
</div>

<div class="form-group">
    <label for="tahun">Tahun:</label>
    <input type="number" name="tahun" id="tahun" class="form-control" value="{{ old('tahun', $layanan->tahun ?? date('Y')) }}" required>
</div>

<hr>
<h5 class="mt-4">Jumlah Produk per Bulan</h5>
<div class="row">
    @for($i = 1; $i <= 12; $i++)
        @php $b = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
        <div class="col-md-3">
            <div class="form-group">
                <label for="bulan_{{ $b }}">Bulan {{ $b }}:</label>
                <input type="number" name="bulan_{{ $b }}" id="bulan_{{ $b }}" class="form-control" value="{{ old("bulan_$b", $layanan["bulan_$b"] ?? 0) }}">
            </div>
        </div>
    @endfor
</div>

<div class="form-group text-right">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($layanan) ? 'Update' : 'Simpan' }}
    </button>
</div>
