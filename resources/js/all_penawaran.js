import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        ajax: base_url+'/penawaran/json',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'pengajuan.nama_proyek', name: 'pengajuan.nama_proyek' },
            { data: 'pengajuan.diskripsi_proyek', name: 'pengajuan.diskripsi_proyek' },
            { data: 'pengajuan.alamat', name: 'pengajuan.alamat' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


