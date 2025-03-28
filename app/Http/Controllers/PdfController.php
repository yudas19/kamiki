<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan alias ini tersedia di config/app.php => 'PDF' => Barryvdh\DomPDF\Facade\Pdf::class

class PdfController extends Controller
{
    public function generateMutasiPdf(Pengajuan $pengajuan)
    {
        $logoFile = file_get_contents(asset('images/pormiki.png'));
        $logoBase64 = 'data:image/' . 'png' . ';base64,' . base64_encode($logoFile);

        $mutasi = $pengajuan->mutasi;
        $data = [
            'logoBase64' => $logoBase64,
            'no_surat' => $mutasi?->no_surat . '/DPD-PORMIKI/JABAR/SM/' . $mutasi?->bulan . '/' . $mutasi?->tahun,
            'jabatan_ketua' => 'Ketua DPD PORMIKI Provinsi Jawa Barat',
            'nama' => $pengajuan?->nama,
            'tempat_lahir' => 'Bandung',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Islam',
            'dpc_baru' => $mutasi?->dpc,
            'kota_surat' => $mutasi?->dpc,
            'tanggal_surat' => $mutasi?->tanggal,
            'nama_ketua' => 'Erik Gunawan, M.M.R.S',
            'jabatan' => 'Anggota',
            'tahun' => '2025'
        ];

        // Memuat view 'pdf.blade.php' dan mengirim data
        $pdf = PDF::loadView('pdf', $data);

        // Pilihan 1: Tampilkan langsung di browser
        return $pdf->stream('surat-keterangan-pindah-keanggotaan.pdf');

        // Pilihan 2: Langsung download file
        // return $pdf->download('surat-keterangan-pindah-keanggotaan.pdf');
    }

    public function generateRekomendasiPdf(Pengajuan $pengajuan)
    {
        $logoFile = file_get_contents(asset('images/pormiki.png'));
        $logoBase64 = 'data:image/' . 'png' . ';base64,' . base64_encode($logoFile);

        $rekomendasi = $pengajuan->rekomendasi;
        $data = [
            'logoBase64' => $logoBase64,
            'no_surat' => $rekomendasi?->no_surat . '/DPD-PORMIKI/JABAR/SM/' . $rekomendasi?->bulan . '/' . $rekomendasi?->tahun,
            'jabatan_ketua' => 'Ketua DPD PORMIKI Provinsi Jawa Barat',
            'nama' => $pengajuan?->nama,
            'tempat_lahir' => 'Bandung',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Islam',
            'dpc_baru' => $rekomendasi?->dpc,
            'kota_surat' => $rekomendasi?->dpc,
            'tanggal_surat' => $rekomendasi?->tanggal,
            'nama_ketua' => 'Erik Gunawan, M.M.R.S',
            'jabatan' => 'Anggota',
            'tahun' => '2025'
        ];

        // Memuat view 'pdf.blade.php' dan mengirim data
        $pdf = PDF::loadView('pdf', $data);

        // Pilihan 1: Tampilkan langsung di browser
        return $pdf->stream('rekomendasi-sik.pdf');

        // Pilihan 2: Langsung download file
        // return $pdf->download('surat-keterangan-pindah-keanggotaan.pdf');
    }
}
