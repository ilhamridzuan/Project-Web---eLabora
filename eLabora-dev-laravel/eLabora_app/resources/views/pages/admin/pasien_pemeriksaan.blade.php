@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Pemeriksaan Pasien')

@section('content')
<div
    x-data="{
        openDetail: false,
        openUpload: false,
        selectedExam: null
    }"
    class="space-y-6">
    {{-- HEADER --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">Pemeriksaan Pasien</h2>
            <p class="mt-1 text-sm text-slate-500">
                @if($pasienName)
                Daftar hasil pemeriksaan untuk pasien: <span class="font-semibold text-slate-700">{{ $pasienName }}</span>
                @else
                Daftar hasil pemeriksaan untuk pasien ID: <span class="font-semibold text-slate-700">{{ $pasienId }}</span>
                @endif
            </p>
        </div>

        <a
            href="{{ route('petugas.pasien') }}"
            class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            ← Kembali
        </a>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
        {{ session('error') }}
    </div>
    @endif

    @if($errorMessage)
    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
        {{ $errorMessage }}
    </div>
    @endif

    {{-- TABLE --}}
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700 w-16">No</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">ID Pemeriksaan</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">ID Pendaftaran</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 text-left">Kategori</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Tgl Pemeriksaan</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Status Validasi</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Status Hasil</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 text-left">Catatan</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($exams as $i => $exam)
                    @php
                    $examId = $exam['pemeriksaan_id'] ?? $exam['id'] ?? null;
                    @endphp
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-4 py-3 text-slate-600 tabular-nums">{{ $i+1 }}</td>

                        <td class="px-4 py-3 text-slate-700 tabular-nums">{{ $examId ?? '-' }}</td>

                        <td class="px-4 py-3 text-slate-700 tabular-nums">{{ $exam['pendaftaran_id'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-left font-medium text-slate-800">{{ $exam['kategori_nama'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-slate-700">{{ $exam['tgl_pemeriksaan'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-slate-700">{{ $exam['status_validasi'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-slate-700">{{ $exam['status_hasil'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-left text-slate-700">
                            <div class="line-clamp-2">{{ $exam['catatan'] ?? '-' }}</div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex gap-2 justify-center">
                                <button
                                    type="button"
                                    @click="openDetail = true; selectedExam = {{ json_encode($exam) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                    Detail / Edit
                                </button>

                                <button
                                    type="button"
                                    @click="openUpload = true; selectedExam = {{ json_encode($exam) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 transition">
                                    Upload
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-700">Belum ada pemeriksaan</p>
                            <p class="text-xs text-slate-500 mt-1">Data pemeriksaan pasien akan muncul setelah dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div x-show="openDetail" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Detail / Edit Pemeriksaan</h3>

            @php
            // route name dipakai di bawah
            @endphp

            <form
                method="POST"
                :action="`{{ route('petugas.pasien.exams.update', ['examId' => 0]) }}`.replace('/0', `/${selectedExam.pemeriksaan_id ?? selectedExam.id}`)"
                class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="text-sm font-medium">Status Validasi</label>
                    <select
                        name="status_validasi"
                        x-model="selectedExam.status_validasi"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm">
                        <option value="DRAFT">DRAFT</option>
                        <option value="TERVALIDASI">TERVALIDASI</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Status Hasil</label>
                    <select
                        name="status_hasil"
                        x-model="selectedExam.status_hasil"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm">
                        <option value="MENUNGGU_HASIL">MENUNGGU_HASIL</option>
                        <option value="HASIL_TERSEDIA">HASIL_TERSEDIA</option>
                        <option value="TIDAK_TERSEDIA">TIDAK_TERSEDIA</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Catatan</label>
                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm"
                        x-model="selectedExam.catatan"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        @click="openDetail=false"
                        class="px-4 py-2 text-sm border rounded-lg">
                        Tutup
                    </button>
                    <button
                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UPLOAD --}}
    <div x-show="openUpload" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div
            class="bg-white w-full max-w-md rounded-xl shadow-lg p-6"
            x-data="{
                fileName: '',
                reset() {
                    this.fileName = '';
                    const inp = this.$refs.fileInput;
                    if (inp) inp.value = '';
                }
            }"
            x-init="$watch('openUpload', (v) => { if (v) reset(); })">
            <h3 class="text-lg font-semibold mb-4">Upload File Pemeriksaan</h3>

            <form
                method="POST"
                enctype="multipart/form-data"
                :action="`{{ route('petugas.pasien.exams.upload', ['examId' => 0]) }}`.replace('/0', `/${selectedExam.pemeriksaan_id ?? selectedExam.id}`)"
                class="space-y-4">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">File (PDF/JPG/PNG)</label>

                    <input
                        x-ref="fileInput"
                        type="file"
                        name="file"
                        required
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden"
                        @change="fileName = $event.target.files?.[0]?.name ?? ''">

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="$refs.fileInput.click()"
                            class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                            Choose File
                        </button>

                        <div class="text-sm text-slate-600 truncate flex-1">
                            <template x-if="fileName">
                                <span class="font-medium text-slate-700" x-text="fileName"></span>
                            </template>
                            <template x-if="!fileName">
                                <span class="text-slate-400">Belum ada file dipilih</span>
                            </template>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400">Maks 5MB. Format: PDF, JPG, PNG.</p>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="openUpload=false"
                        class="px-4 py-2 text-sm border border-slate-200 rounded-lg bg-white text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <button
                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        :disabled="!fileName"
                        :class="!fileName ? 'opacity-60 cursor-not-allowed' : ''">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection