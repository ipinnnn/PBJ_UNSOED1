<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UnitController extends Controller
{
    public function dashboard()
    {
        // Kalau blade dashboard butuh nama unit, siapkan aja:
        $unitName = "Fakultas Teknik";

        return view('Unit.Dashboard', compact('unitName'));
    }

    public function arsipIndex(Request $request)
    {
        $unitName = "Fakultas Teknik";

        // Dummy data tabel arsip (silakan sesuaikan kalau blade kamu butuh field tertentu)
        // NOTE: field ini sengaja pakai schema yang nyambung ke blade kamu
        $arsipList = [
            [
                'id' => 1,
                'pekerjaan' => 'Pengadaan Laptop | RUP-2026-001-FT',
                'tahun' => 2025,
                'metode_pbj' => 'E-Purchasing / E-Catalogue',
                'nilai_kontrak' => 'Rp. 10.000.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Selesai',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 2,
                'pekerjaan' => 'Pengadaan ATK | RUP-2026-002-FT',
                'tahun' => 2024,
                'metode_pbj' => 'Pengadaan Langsung',
                'nilai_kontrak' => 'Rp. 2.500.000,00',
                'status_arsip' => 'Privat',
                'status_pekerjaan' => 'Pelaksanaan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 3,
                'pekerjaan' => 'Pengadaan Printer | RUP-2026-003-FT',
                'tahun' => 2025,
                'metode_pbj' => 'Pengadaan Langsung',
                'nilai_kontrak' => 'Rp. 3.750.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Pemilihan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 4,
                'pekerjaan' => 'Pengadaan Proyektor | RUP-2026-004-FT',
                'tahun' => 2024,
                'metode_pbj' => 'E-Purchasing / E-Catalogue',
                'nilai_kontrak' => 'Rp. 8.200.000,00',
                'status_arsip' => 'Privat',
                'status_pekerjaan' => 'Perencanaan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 5,
                'pekerjaan' => 'Pengadaan Server | RUP-2026-005-FT',
                'tahun' => 2025,
                'metode_pbj' => 'Tender',
                'nilai_kontrak' => 'Rp. 150.000.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Pelaksanaan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 6,
                'pekerjaan' => 'Pengadaan Router | RUP-2026-006-FT',
                'tahun' => 2024,
                'metode_pbj' => 'Pengadaan Langsung',
                'nilai_kontrak' => 'Rp. 5.500.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Selesai',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 7,
                'pekerjaan' => 'Pengadaan Switch Jaringan | RUP-2026-007-FT',
                'tahun' => 2025,
                'metode_pbj' => 'Tender',
                'nilai_kontrak' => 'Rp. 22.000.000,00',
                'status_arsip' => 'Privat',
                'status_pekerjaan' => 'Pemilihan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 8,
                'pekerjaan' => 'Pengadaan CCTV Gedung | RUP-2026-008-FT',
                'tahun' => 2024,
                'metode_pbj' => 'Pengadaan Langsung',
                'nilai_kontrak' => 'Rp. 18.750.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Perencanaan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 9,
                'pekerjaan' => 'Pengadaan Software CAD | RUP-2026-009-FT',
                'tahun' => 2025,
                'metode_pbj' => 'Tender',
                'nilai_kontrak' => 'Rp. 65.000.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Pelaksanaan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 10,
                'pekerjaan' => 'Pengadaan Meja Laboratorium | RUP-2026-010-FT',
                'tahun' => 2024,
                'metode_pbj' => 'Pengadaan Langsung',
                'nilai_kontrak' => 'Rp. 12.800.000,00',
                'status_arsip' => 'Privat',
                'status_pekerjaan' => 'Selesai',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 11,
                'pekerjaan' => 'Pengadaan Kursi Auditorium | RUP-2026-011-FT',
                'tahun' => 2025,
                'metode_pbj' => 'Tender',
                'nilai_kontrak' => 'Rp. 95.000.000,00',
                'status_arsip' => 'Publik',
                'status_pekerjaan' => 'Pemilihan',
                'unit' => 'Fakultas Teknik',
            ],
            [
                'id' => 12,
                'pekerjaan' => 'Pengadaan AC Ruang Dosen | RUP-2026-012-FT',
                'tahun' => 2024,
                'metode_pbj' => 'E-Purchasing / E-Catalogue',
                'nilai_kontrak' => 'Rp. 27.500.000,00',
                'status_arsip' => 'Privat',
                'status_pekerjaan' => 'Pelaksanaan',
                'unit' => 'Fakultas Teknik',
            ],
        ];

        // =========================
        // ✅ PAGINATION (DUMMY) - bikin $arsips jadi LengthAwarePaginator
        // =========================
        $perPage = (int) ($request->get('per_page', 6)); // biar kelihatan pagination
        $page    = (int) ($request->get('page', 1));

        $collection = Collection::make($arsipList);
        $total = $collection->count();

        $items = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $arsips = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(), // supaya query string tetap kebawa
            ]
        );

        // ✅ Blade kamu butuh $arsips untuk munculin pagination
        return view('Unit.ArsipPBJ', compact('unitName', 'arsips'));
    }

    public function arsipEdit($id)
    {
        $unitName = "Fakultas Teknik";

        // Dummy 1 arsip untuk edit page
        // Penting: bikin object agar bisa dipanggil $arsip->id di blade
        $arsip = (object) [
            'id' => (int) $id,
            'judul' => 'Pengadaan Laptop',
            'tahun' => 2025,
            'metode' => 'E-Purchasing / E-Catalogue',
            'status' => 'Selesai',
        ];

        return view('Unit.EditArsip', compact('unitName', 'arsip'));
    }

    public function arsipUpdate(Request $request, $id)
    {
        // sementara dummy: validasi minimal biar aman
        $request->validate([
            'judul'  => 'nullable|string|max:255',
            'tahun'  => 'nullable|integer',
            'metode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        // TODO: kalau sudah ada model, lakukan update di sini

        return redirect()
            ->route('unit.arsip')
            ->with('success', 'Arsip berhasil diperbarui (dummy).');
    }

    public function pengadaanCreate()
    {
        $unitName = "Fakultas Teknik";

        // ✅ Dummy opsi (biar UNIT sama kaya PPK)
        $tahunOptions = [2022, 2023, 2024, 2025, 2026];
        $unitOptions  = ["Fakultas Teknik", "Fakultas Hukum", "Fakultas Ekonomi dan Bisnis"];
        $jenisPengadaanOptions = ["Tender", "E-Katalog", "Pengadaan Langsung", "Seleksi", "Penunjukan Langsung"];
        $statusPekerjaanOptions = ["Perencanaan", "Pemilihan", "Pelaksanaan", "Selesai"];

        // ✅ Dummy judul dokumen (kolom D) - dipakai untuk generate list "Tidak Dipersyaratkan" juga
        $dokumenPengadaanOptions = [
            "Kerangka Acuan Kerja atau KAK",
            "Harga Perkiraan Sendiri atau HPS",
            "Spesifikasi Teknis",
            "Rancangan Kontrak",
            "Lembar Data Kualifikasi",
            "Lembar Data Pemilihan",
            "Daftar Kuantitas dan Harga",
            "Jadwal dan Lokasi Pekerjaan",
            "Gambar Rancangan Pekerjaan",
            "Dokumen Analisis Mengenai Dampak Lingkungan atau AMDAL",
            "Dokumen Penawaran",
            "Surat Penawaran",
            "Sertifikat atau Lisensi Kemenkumham",
            "Berita Acara Pemberian Penjelasan",
            "Berita Acara Pengumuman Negosiasi",
            "Berita Acara Sanggah dan Sanggah Banding",
            "Berita Acara Penetapan",
            "Laporan Hasil Pemilihan Penyedia",
            "Surat Penunjukan Penyedia Barang Jasa atau SPPBJ",
            "Surat Perjanjian Kemitraan",
            "Surat Perjanjian Swakelola",
            "Surat Penugasan Tim Swakelola",
            "Nota Kesepahaman atau MoU",
            "Dokumen Kontrak",
            "Ringkasan Kontrak",
            "Surat Jaminan Pelaksanaan",
            "Surat Jaminan Uang Muka",
            "Surat Jaminan Pemeliharaan",
            "Surat Tagihan",
            "Surat Pesanan Elektronik atau E-Purchasing",
            "Surat Perintah Mulai Kerja atau SPMK",
            "Surat Perintah Perjalanan Dinas atau SPPD",
            "Laporan Pelaksanaan Pekerjaan",
            "Laporan Penyelesaian Pekerjaan",
            "Berita Acara Pembayaran atau BAP",
            "Berita Acara Serah Terima Sementara atau BAST Sementara",
            "Berita Acara Serah Terima Final atau BAST Final",
            "Dokumen Pendukung Lainya",
        ];

        // ✅ Dummy: biar kelihatan "udah keisi" (opsional)
        $dokumenTidakDipersyaratkanDummy = [
            "Dokumen Analisis Mengenai Dampak Lingkungan atau AMDAL",
            "Surat Perintah Perjalanan Dinas atau SPPD",
        ];

        return view('Unit.TambahPengadaan', compact(
            'unitName',
            'tahunOptions',
            'unitOptions',
            'jenisPengadaanOptions',
            'statusPekerjaanOptions',
            'dokumenPengadaanOptions',
            'dokumenTidakDipersyaratkanDummy'
        ));
    }

    public function pengadaanStore(Request $request)
    {
        // dummy validasi minimal
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',

            // ✅ biar aman kalau form kamu kirim ini juga
            'dokumen_tidak_dipersyaratkan' => 'nullable|array',
            'dokumen_tidak_dipersyaratkan.*' => 'nullable|string|max:255',
            'dokumen_tidak_dipersyaratkan_json' => 'nullable|string',
        ]);

        // TODO: simpan ke DB kalau sudah siap

        return redirect()
            ->route('unit.pengadaan.create')
            ->with('success', 'Pengadaan berhasil disimpan (dummy).');
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ KELOLA AKUN (UNIT)
    |--------------------------------------------------------------------------
    */

    public function kelolaAkun()
    {
        // kalau blade butuh nama unit
        $unitName = "Fakultas Teknik";

        // untuk header sidebar di blade
        $unitRoleText = 'ADMIN (UNIT)';

        // (opsional) kalau kamu mau kirim variabel tambahan, tapi blade kamu juga sudah bisa ambil auth()->user()
        return view('Unit.KelolaAkun', compact('unitName', 'unitRoleText'));
    }

    public function updateAkun(Request $request)
    {
        // ✅ validasi aman (dummy dulu)
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',

            // password opsional (kalau user isi password baru)
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // ✅ kalau sudah pakai auth & DB:
        // $user = auth()->user();
        // $user->name = $request->name;
        // $user->email = $request->email;
        //
        // if ($request->filled('password')) {
        //   if (!Hash::check($request->current_password, $user->password)) {
        //     return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
        //   }
        //   $user->password = Hash::make($request->password);
        // }
        //
        // $user->save();

        return redirect()
            ->route('unit.kelola.akun')
            ->with('success', 'Akun berhasil diperbarui (dummy).');
    }
}
