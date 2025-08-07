<div class="form-group">
    <label for="nip">Pegawai</label>
    <select name="nip" id="nip" class="form-control select2">
        @foreach($pegawai as $p)
            <option value="{{ $p->nip }}" {{ old('nip', $item->nip ?? '') == $p->nip ? 'selected' : '' }}>
                {{ $p->nama }} ({{ $p->nip }})
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <div class="row">

        <div class="col-md-6">
            <label for="bulan">Bulan</label>
            <select name="bulan" id="bulan" class="form-control select2">
                @php
                    $bulanList = [
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ];
                    $selectedBulan = old('bulan', $item->bulan ?? date('m'));
                @endphp
                @foreach($bulanList as $num => $nama)
                    <option value="{{ $num }}" {{ $selectedBulan == $num ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="col-md-6">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-control select2">
                @php
                    $tahunSekarang = date('Y');
                    $selectedTahun = old('tahun', $item->tahun ?? $tahunSekarang);
                @endphp

                @for ($tahun = 2025; $tahun <= 2026; $tahun++)
                    <option value="{{ $tahun }}" {{ $selectedTahun == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</div>


<div class="form-group">
    <label for="nilai">Nilai</label>
    <select name="nilai" id="nilai" class="form-control select2">
        @php
            $daftarNilai = [
                25 => 'Kurang Baik',
                50 => 'Cukup Baik',
                75 => 'Baik',
                100 => 'Sangat Baik',
            ];
            $selected = old('nilai', $item->nilai ?? 100); // default ke 100
        @endphp

        @foreach($daftarNilai as $angka => $label)
            <option value="{{ $angka }}" {{ $selected == $angka ? 'selected' : '' }}>
                {{ $angka }} - {{ $label }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan', $item->keterangan ?? '') }}</textarea>
</div>
