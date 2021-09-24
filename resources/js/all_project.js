import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        ajax: base_url+'/projek/json',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'pembayaran.pin.pengajuan.nama_proyek', name: 'pembayaran.pin.pengajuan.nama_proyek' },
            { data: 'pembayaran.pin.pengajuan.diskripsi_proyek', name: 'pembayaran.pin.pengajuan.diskripsi_proyek' },
            { data: 'pembayaran.pin.pengajuan.alamat', name: 'pembayaran.pin.pengajuan.alamat' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


