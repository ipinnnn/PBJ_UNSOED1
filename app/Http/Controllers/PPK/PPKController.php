<?php

namespace App\Http\Controllers\PPK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PpkController extends Controller
{
    public function dashboard()
    {
        // kalau sudah pakai auth, bisa tampilkan nama user login
        $ppkName = auth()->user()->name ?? "PPK Utama";

        return view('PPK.Dashboard', compact('ppkName'));
    }

    public function arsipIndex(Request $request)
    {
        $ppkName = auth()->user()->name ?? "PPK Utama";

        // =========================
        // ✅ DUMMY DATA: 12 DATA BERBEDA
        // - paginate per halaman pakai $perPage
        // - sudah ada field detail + kolom E (dokumen_tidak_dipersyaratkan)
        // =========================
        $arsipList = [
            [
                'id' => 101,
                'judul' => 'Pengadaan Server Virtualisasi',
                'tahun' => 2025,
                'metode' => 'Tender Terbuka',
                'status' => 'Pemilihan',
                'nilai_kontrak' => 'Rp. 980.000.000,00',

                'unit' => 'UPT TIK',
                'status_arsip' => 'Privat',
                'idrup' => '2026-009',
                'rekanan' => 'PT Data Cloud Indonesia',
                'jenis' => 'Tender',
                'pagu' => 'Rp 1.050.000.000',
                'hps' => 'Rp 1.020.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen Kolom E tidak dipersyaratkan. Jika ada, unggah sebagai dokumen pendukung.',
            ],
            [
                'id' => 102,
                'judul' => 'Pengadaan Perangkat Presentasi Ruang Rapat',
                'tahun' => 2024,
                'metode' => 'E-Purchasing',
                'status' => 'Pelaksanaan',
                'nilai_kontrak' => 'Rp. 185.000.000,00',

                'unit' => 'Fakultas Ekonomi dan Bisnis',
                'status_arsip' => 'Privat',
                'idrup' => '2026-002',
                'rekanan' => 'CV Sinar Media',
                'jenis' => 'E-Katalog',
                'pagu' => 'Rp 200.000.000',
                'hps' => 'Rp 195.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Kolom E berisi dokumen pendukung (opsional). Jika tidak diunggah, proses tetap dapat berjalan.',
            ],
            [
                'id' => 103,
                'judul' => 'Pengadaan Laboratorium Komputer Terpadu',
                'tahun' => 2024,
                'metode' => 'Pengadaan Langsung',
                'status' => 'Perencanaan',
                'nilai_kontrak' => 'Rp. 1.250.000.000,00',

                'unit' => 'Fakultas Teknik',
                'status_arsip' => 'Publik',
                'idrup' => '2026-001',
                'rekanan' => 'PT Teknologi Maju Nusantara',
                'jenis' => 'Tender',
                'pagu' => 'Rp 1.300.000.000',
                'hps' => 'Rp 1.280.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen pada Kolom E bersifat opsional (tidak dipersyaratkan).',
            ],
            [
                'id' => 104,
                'judul' => 'Pemeliharaan Jaringan Internet Kampus',
                'tahun' => 2024,
                'metode' => 'Pengadaan Langsung',
                'status' => 'Pelaksanaan',
                'nilai_kontrak' => 'Rp. 95.000.000,00',

                'unit' => 'Fakultas Hukum',
                'status_arsip' => 'Publik',
                'idrup' => '2026-003',
                'rekanan' => 'PT Netlink Solusi',
                'jenis' => 'Non Tender',
                'pagu' => 'Rp 100.000.000',
                'hps' => 'Rp 98.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen pada Kolom E tidak dipersyaratkan untuk pengadaan ini.',
            ],
            [
                'id' => 105,
                'judul' => 'Pengadaan Alat Kesehatan Klinik',
                'tahun' => 2024,
                'metode' => 'Tender Cepat',
                'status' => 'Selesai',
                'nilai_kontrak' => 'Rp. 620.000.000,00',

                'unit' => 'Fakultas Kedokteran',
                'status_arsip' => 'Privat',
                'idrup' => '2026-004',
                'rekanan' => 'PT Medika Sehat Sentosa',
                'jenis' => 'Tender',
                'pagu' => 'Rp 650.000.000',
                'hps' => 'Rp 640.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen Kolom E (opsional): surat dukungan / brosur tambahan.',
            ],
            [
                'id' => 106,
                'judul' => 'Pengadaan Bibit dan Pupuk Praktikum',
                'tahun' => 2023,
                'metode' => 'E-Purchasing',
                'status' => 'Selesai',
                'nilai_kontrak' => 'Rp. 75.500.000,00',

                'unit' => 'Fakultas Pertanian',
                'status_arsip' => 'Publik',
                'idrup' => '2025-005',
                'rekanan' => 'UD Tani Makmur',
                'jenis' => 'E-Katalog',
                'pagu' => 'Rp 80.000.000',
                'hps' => 'Rp 79.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen pada Kolom E bersifat opsional (tidak dipersyaratkan).',
            ],
            [
                'id' => 107,
                'judul' => 'Pengadaan Buku Referensi Perpustakaan',
                'tahun' => 2023,
                'metode' => 'E-Purchasing',
                'status' => 'Pelaksanaan',
                'nilai_kontrak' => 'Rp. 120.000.000,00',

                'unit' => 'Fakultas Ilmu Budaya',
                'status_arsip' => 'Privat',
                'idrup' => '2025-006',
                'rekanan' => 'PT Pustaka Utama',
                'jenis' => 'E-Katalog',
                'pagu' => 'Rp 130.000.000',
                'hps' => 'Rp 128.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Kolom E tidak wajib. Silakan unggah jika ada dokumen pendukung tambahan.',
            ],
            [
                'id' => 108,
                'judul' => 'Pengadaan Reagen Laboratorium Kimia',
                'tahun' => 2023,
                'metode' => 'Tender',
                'status' => 'Pemilihan',
                'nilai_kontrak' => 'Rp. 410.000.000,00',

                'unit' => 'Fakultas MIPA',
                'status_arsip' => 'Publik',
                'idrup' => '2025-007',
                'rekanan' => 'PT Labindo Raya',
                'jenis' => 'Tender',
                'pagu' => 'Rp 450.000.000',
                'hps' => 'Rp 440.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen Kolom E opsional (tidak dipersyaratkan).',
            ],
            [
                'id' => 109,
                'judul' => 'Jasa Konsultansi Penyusunan Roadmap Riset',
                'tahun' => 2024,
                'metode' => 'Seleksi',
                'status' => 'Perencanaan',
                'nilai_kontrak' => 'Rp. 275.000.000,00',

                'unit' => 'LPPM',
                'status_arsip' => 'Publik',
                'idrup' => '2026-008',
                'rekanan' => 'PT Konsultan Mandiri',
                'jenis' => 'Seleksi',
                'pagu' => 'Rp 300.000.000',
                'hps' => 'Rp 295.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Kolom E berisi lampiran tambahan (opsional), misalnya TOR versi revisi.',
            ],
            [
                'id' => 110,
                'judul' => 'Pengadaan Peralatan Kebersihan Gedung',
                'tahun' => 2024,
                'metode' => 'Pengadaan Langsung',
                'status' => 'Selesai',
                'nilai_kontrak' => 'Rp. 48.500.000,00',

                'unit' => 'Biro Umum',
                'status_arsip' => 'Publik',
                'idrup' => '2026-010',
                'rekanan' => 'CV Bersih Jaya',
                'jenis' => 'Non Tender',
                'pagu' => 'Rp 50.000.000',
                'hps' => 'Rp 49.500.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen pada Kolom E bersifat opsional (tidak dipersyaratkan).',
            ],
            [
                'id' => 111,
                'judul' => 'Pengadaan Pakan Ternak Praktikum',
                'tahun' => 2024,
                'metode' => 'E-Purchasing',
                'status' => 'Pemilihan',
                'nilai_kontrak' => 'Rp. 135.000.000,00',

                'unit' => 'Fakultas Peternakan',
                'status_arsip' => 'Privat',
                'idrup' => '2026-011',
                'rekanan' => 'PT Agro Feed Nusantara',
                'jenis' => 'E-Katalog',
                'pagu' => 'Rp 150.000.000',
                'hps' => 'Rp 147.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Kolom E opsional: sertifikat/COA tambahan (jika tersedia).',
            ],
            [
                'id' => 112,
                'judul' => 'Pengadaan Lisensi Software Pembelajaran',
                'tahun' => 2023,
                'metode' => 'Tender Cepat',
                'status' => 'Perencanaan',
                'nilai_kontrak' => 'Rp. 360.000.000,00',

                'unit' => 'LPMPP',
                'status_arsip' => 'Publik',
                'idrup' => '2025-012',
                'rekanan' => 'PT Edu Tech Solution',
                'jenis' => 'Tender',
                'pagu' => 'Rp 390.000.000',
                'hps' => 'Rp 385.000.000',

                'dokumen_tidak_dipersyaratkan' => 'Dokumen pada Kolom E tidak dipersyaratkan untuk pengadaan ini.',
            ],
        ];

        // =========================
        // PAGINATION (dari array)
        // =========================
        $perPage = 6; // ✅ maksimal per halaman (ubah ke 10 kalau kamu mau)
        $page = (int) $request->query('page', 1);
        if ($page < 1) $page = 1;

        $total = count($arsipList);
        $offset = ($page - 1) * $perPage;

        $items = array_slice($arsipList, $offset, $perPage);

        $arsips = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('PPK.ArsipPBJ', compact('ppkName', 'arsips'));
    }

    public function arsipEdit($id)
    {
        $ppkName = auth()->user()->name ?? "PPK Utama";

        $arsip = (object) [
            'id' => (int) $id,
            'judul' => 'Pengadaan Server',
            'tahun' => 2025,
            'metode' => 'Tender Terbuka',
            'status' => 'Pemilihan',
        ];

        return view('PPK.EditArsip', compact('ppkName', 'arsip'));
    }

    public function arsipUpdate(Request $request, $id)
    {
        $request->validate([
            'judul'  => 'nullable|string|max:255',
            'tahun'  => 'nullable|integer',
            'metode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        return redirect()
            ->route('ppk.arsip')
            ->with('success', 'Arsip berhasil diperbarui (dummy).');
    }

    public function pengadaanCreate()
    {
        $ppkName = auth()->user()->name ?? "PPK Utama";

        return view('PPK.TambahPengadaan', compact('ppkName'));
    }

    public function pengadaanStore(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
        ]);

        return redirect()
            ->route('ppk.pengadaan.create')
            ->with('success', 'Pengadaan berhasil disimpan (dummy).');
    }

    // =========================
    // ✅ KELOLA AKUN (PPK)
    // =========================
    public function kelolaAkun()
    {
        $ppkName = auth()->user()->name ?? "PPK Utama";

        return view('PPK.KelolaAkun', compact('ppkName'));
    }

    // =========================
    // ✅ UPDATE AKUN (PPK)
    // - update name/email
    // - update password jika diisi (wajib current_password)
    // =========================
    public function updateAkun(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors(['auth' => 'Kamu belum login. Silakan login dulu.'])
                ->withInput();
        }

        // kalau password mau diganti, cek current_password wajib
        $wantsPasswordChange = $request->filled('password') || $request->filled('password_confirmation');

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ];

        if ($wantsPasswordChange) {
            $rules['current_password'] = ['required', 'string'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        } else {
            // kalau tidak ubah password, biarkan nullable
            $rules['current_password'] = ['nullable', 'string'];
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        $data = $request->validate($rules);

        // Update name & email
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Update password jika diminta
        if ($wantsPasswordChange) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return redirect()
                    ->back()
                    ->withErrors(['current_password' => 'Password saat ini salah.'])
                    ->withInput();
            }

            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('ppk.kelola.akun')
            ->with('success', 'Akun berhasil diperbarui.');
    }
}
