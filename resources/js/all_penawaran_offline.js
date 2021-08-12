import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: base_url+'/penawaran-offline/json',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama_proyek', name: 'nama_proyek' },
            { data: 'diskripsi_proyek', name: 'diskripsi_proyek' },
            { data: 'alamat_proyek', name: 'alamat_proyek' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


