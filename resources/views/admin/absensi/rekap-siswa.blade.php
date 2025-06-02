@extends('layouts.app')
@section('title', 'Rekap Kehadiran Siswa')

@section('content')
<section class="section">
    <div class="row" id="table-responsive">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-2 mb-md-0">
                        Rekap Absensi Bulan {{ \Carbon\Carbon::create(null, $bulan)->translatedFormat('F') }}
                    </h4>

                    <form method="GET" action="{{ route('admin.absensi.rekap-siswa') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <label for="kelas_id" class="mb-0 text-nowrap">Pilih Kelas:</label>
                        <select name="kelas_id" id="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="" {{ $kelas_id == '' ? 'selected' : '' }}>-- Semua Kelas --</option>
                            @foreach ($kelasList as $kelasItem)
                                <option value="{{ $kelasItem->id }}" {{ $kelas_id == $kelasItem->id ? 'selected' : '' }}>
                                    {{ $kelasItem->nama_kelas }}
                                </option>
                            @endforeach
                        </select>


                        <label for="bulan" class="mb-0 text-nowrap">Pilih Bulan:</label>
                        <select name="bulan" id="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(null, $i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 text-center">
                            <thead class="bg-white text-dark">
                                <tr>
                                    <th class="align-middle">Nama</th>
                                    @for ($i = 1; $i <= $jumlahHari; $i++)
                                        @php
                                            $tanggal = \Carbon\Carbon::create(null, $bulan, $i)->format('Y-m-d');
                                            $tags = $penandaHari[$tanggal] ?? [];
                                        @endphp
                                        <th class="align-middle">
                                            {{ $i }}
                                            @foreach ($tags as $tag)
                                                <div>
                                                    <span class="badge
                                                        {{ $tag === 'Minggu' ? 'bg-secondary' : 'bg-warning text-dark' }} small">
                                                        {{ $tag }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </th>
                                    @endfor
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($siswaList as $siswa)
                                    <tr>
                                        <td>{{ $siswa->name }}</td>
                                        @for ($i = 1; $i <= $jumlahHari; $i++)
                                            @php
                                                $tanggal = \Carbon\Carbon::create(null, $bulan, $i)->format('Y-m-d');
                                                $isLibur = in_array($tanggal, $hariLibur);
                                                $isMinggu = \Carbon\Carbon::parse($tanggal)->isSunday();
                                                $status = $rekap[$siswa->id][$tanggal] ?? '';

                                                if ($isLibur || $isMinggu) {
                                                    $warna = 'secondary';  // abu-abu
                                                    $statusTampil = 'L';
                                                } else {
                                                    $warna = match($status) {
                                                        'Hadir' => 'success',
                                                        'Alpha' => 'danger',
                                                        'Izin' => 'warning',
                                                        'Sakit' => 'info',
                                                        default => 'light',
                                                    };
                                                    $statusTampil = $status ? strtoupper(substr($status, 0, 1)) : '-';
                                                }

                                                $textColor = in_array($warna, ['light', 'warning', 'secondary']) ? 'text-dark' : 'text-white';
                                            @endphp

                                            <td class="bg-{{ $warna }} {{ $textColor }} align-middle">
                                                <button
                                                    class="btn btn-sm btn-{{ $warna }} {{ $textColor }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editStatusModal"
                                                    data-userid="{{ $siswa->id }}"
                                                    data-tanggal="{{ $tanggal }}"
                                                    data-status="{{ $status }}"
                                                    style="width: 100%; padding: 0;"
                                                >
                                                    {{ $statusTampil }}
                                                </button>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>

                    <div class="mt-4">
                        <h6>Keterangan Warna:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-success">H = Hadir</span>
                            <span class="badge bg-danger">A = Alpha</span>
                            <span class="badge bg-warning text-dark">I = Izin</span>
                            <span class="badge bg-info text-white">S = Sakit</span>
                            <span class="badge bg-light text-dark">- = Tidak Ada Data</span>
                            <span class="badge bg-secondary">Minggu</span>
                            <span class="badge bg-warning text-dark">Libur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('absensi.update-status') }}">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editStatusModalLabel">Edit Status Absensi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="user_id" id="modalUserId">
              <input type="hidden" name="tanggal" id="modalTanggal">

              <div class="mb-3">
                  <label for="modalStatus" class="form-label">Status</label>
                  <select name="status" id="modalStatus" class="form-select" required>
                      <option value="Hadir">Hadir</option>
                      <option value="Alpha">Alpha</option>
                      <option value="Izin">Izin</option>
                      <option value="Sakit">Sakit</option>
                  </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
      </form>
    </div>
  </div>
</section>
@section('js')
<script>
    var editStatusModal = document.getElementById('editStatusModal')
    editStatusModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var userId = button.getAttribute('data-userid')
        var tanggal = button.getAttribute('data-tanggal')
        var status = button.getAttribute('data-status')

        var modalUserId = editStatusModal.querySelector('#modalUserId')
        var modalTanggal = editStatusModal.querySelector('#modalTanggal')
        var modalStatus = editStatusModal.querySelector('#modalStatus')

        modalUserId.value = userId
        modalTanggal.value = tanggal
        modalStatus.value = status || ''
    })
</script>
@endsection
@endsection
