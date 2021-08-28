import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: base_url+'/admin/pembayaran/json',
        columnDefs: [
            {
                targets: 3,
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp. ' )
            },
        ],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'pin.pengajuan.nama_proyek', name: 'pin.pengajuan.nama_proyek' },
            { data: 'pin.pengajuan.client.user.name', name: 'pin.pengajuan.client.user.name' },
            { data: 'total_tagihan', name: 'total_tagihan' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


