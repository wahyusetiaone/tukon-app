<?php

namespace Database\Seeders;

use App\Models\KodeStatus;
use Illuminate\Database\Seeder;

class KodeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kode = new KodeStatus();
        $kode->kode_status='B01';
        $kode->nama_kode='Dibatalkan Oleh Klien';
        $kode->keterangan='Proses ini telah dibatalkan oleh Klien';
        $kode->save();

        $kode1 = new KodeStatus();
        $kode1->kode_status='B02';
        $kode1->nama_kode='Dibatalkan Oleh Tukang';
        $kode1->keterangan='Proses ini telah dibatalkan oleh Tukang';
        $kode1->save();

        $kode2 = new KodeStatus();
        $kode2->kode_status='B03';
        $kode2->nama_kode='Dibatalkan Oleh Admin';
        $kode2->keterangan='Proses ini telah dibatalkan oleh Admin';
        $kode2->save();

        $kode2a = new KodeStatus();
        $kode2a->kode_status='B04';
        $kode2a->nama_kode='Pengajuna telah dimenangkan pihak lain';
        $kode2a->keterangan='Maaf pengajuan telah dimenangkan oleh pihak lain';
        $kode2a->save();

        $kode3 = new KodeStatus();
        $kode3->kode_status='D01A';
        $kode3->nama_kode='Deal Klien';
        $kode3->keterangan='Proses ini telah disetujui oleh Klien';
        $kode3->save();

        $kode4 = new KodeStatus();
        $kode4->kode_status='D01B';
        $kode4->nama_kode='Deal Tukang';
        $kode4->keterangan='Proses ini telah disetujui oleh Tukang';
        $kode4->save();

        $kode5 = new KodeStatus();
        $kode5->kode_status='D02';
        $kode5->nama_kode='Deal';
        $kode5->keterangan='Proses ini telah disetujui kedua belah pihak';
        $kode5->save();

        $kode6 = new KodeStatus();
        $kode6->kode_status='P01';
        $kode6->nama_kode='Menunggu Pembayaran';
        $kode6->keterangan='Proses ini telah menunggu pembayaran';
        $kode6->save();

        $kode6a = new KodeStatus();
        $kode6a->kode_status='P01A';
        $kode6a->nama_kode='Menunggu ReUploading Pembayaran';
        $kode6a->keterangan='Menunggu pegulangan pengungahan bukti transaksi';
        $kode6a->save();

        $kode6b = new KodeStatus();
        $kode6b->kode_status='P01B';
        $kode6b->nama_kode='Menunggu Verifikasi Pembayaran';
        $kode6b->keterangan='Menunggu Verifikasi Transaksi Pembayaran oleh admin';
        $kode6b->save();

        $kode7 = new KodeStatus();
        $kode7->kode_status='P02';
        $kode7->nama_kode='Pembayaran Gagal';
        $kode7->keterangan='Proses ini dihentikan karena proses pembayaran tidak di laksanakan';
        $kode7->save();

        $kode8 = new KodeStatus();
        $kode8->kode_status='P03';
        $kode8->nama_kode='Pembayaran Sukses';
        $kode8->keterangan='Proses pembarayan sukses';
        $kode8->save();

        $kode10 = new KodeStatus();
        $kode10->kode_status='T01';
        $kode10->nama_kode='Pengajuan Terkirim';
        $kode10->keterangan='Pengajuan telah terkirim ke tukang';
        $kode10->save();

        $kode11 = new KodeStatus();
        $kode11->kode_status='T02';
        $kode11->nama_kode='Tukang menerbitkan penawaran';
        $kode11->keterangan='Tukang menerbitkan sebuah penawaran untuk projek ini';
        $kode11->save();

        $kode11 = new KodeStatus();
        $kode11->kode_status='T02A';
        $kode11->nama_kode='Klien meminta revisi penawaran';
        $kode11->keterangan='Klien telah meminta perubahan penawaran untuk projek ini';
        $kode11->save();

        $kode12 = new KodeStatus();
        $kode12->kode_status='T03';
        $kode12->nama_kode='Tukang Menolak Pengajuan';
        $kode12->keterangan='Pengajuan telah ditolak oleh tukang';
        $kode12->save();

        $kode13 = new KodeStatus();
        $kode13->kode_status='N01';
        $kode13->nama_kode='Pengajuan Diterima';
        $kode13->keterangan='Sebuah pengajuan telah diterima';
        $kode13->save();

        $kode14 = new KodeStatus();
        $kode14->kode_status='S01';
        $kode14->nama_kode='Tidak disunting';
        $kode14->keterangan='Dokumen tidak disunting';
        $kode14->save();

        $kode15 = new KodeStatus();
        $kode15->kode_status='S02';
        $kode15->nama_kode='Sunting';
        $kode15->keterangan='Dokumen telah disunting';
        $kode15->save();

        $kode16 = new KodeStatus();
        $kode16->kode_status='A01';
        $kode16->nama_kode='Menunggu Konfrimasi Admin';
        $kode16->keterangan='Menunggu pembayaran dikonfirmasi oleh admin';
        $kode16->save();

        $kode17 = new KodeStatus();
        $kode17->kode_status='A02';
        $kode17->nama_kode='Pembayaran ditolak Admin';
        $kode17->keterangan='Transaksi Pembayaran di tolak oleh admin';
        $kode17->save();

        $kode18 = new KodeStatus();
        $kode18->kode_status='A03';
        $kode18->nama_kode='Pembayaran dikonfirmasi oleh Admin';
        $kode18->keterangan='Transaksi Pembayaran telah dikonfirmasi oleh admin';
        $kode18->save();

        $kode19 = new KodeStatus();
        $kode19->kode_status='ON01';
        $kode19->nama_kode='Dalam proses pengerjaan';
        $kode19->keterangan='Projek masih dalam proses pengerjaan';
        $kode19->save();

        $kode20 = new KodeStatus();
        $kode20->kode_status='ON02';
        $kode20->nama_kode='Projek selesai Klien';
        $kode20->keterangan='Projek telah diverikiasi selesai oleh Klien';
        $kode20->save();

        $kode21 = new KodeStatus();
        $kode21->kode_status='ON03';
        $kode21->nama_kode='Projek dibatalkan';
        $kode21->keterangan='Projek dibatalkan karena alasan tertentu';
        $kode21->save();

        $kode22 = new KodeStatus();
        $kode22->kode_status='ON04';
        $kode22->nama_kode='Projek selesai Tukang';
        $kode22->keterangan='Projek telah diverikiasi selesai oleh Tukang';
        $kode22->save();

        $kode23 = new KodeStatus();
        $kode23->kode_status='ON05';
        $kode23->nama_kode='Projek selesai';
        $kode23->keterangan='Projek telah selesai';
        $kode23->save();

        $kode24 = new KodeStatus();
        $kode24->kode_status='V01';
        $kode24->nama_kode='Tukang Belum Verified';
        $kode24->keterangan='Tukang Belum Verified';
        $kode24->save();

        $kode25 = new KodeStatus();
        $kode25->kode_status='V02';
        $kode25->nama_kode='Menunggu Verification';
        $kode25->keterangan='Menunggu di Verification';
        $kode25->save();

        $kode26 = new KodeStatus();
        $kode26->kode_status='V01';
        $kode26->nama_kode='Tukang Verified';
        $kode26->keterangan='Tukang Verified';
        $kode26->save();
    }
}
