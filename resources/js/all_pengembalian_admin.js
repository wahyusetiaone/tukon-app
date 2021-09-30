import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        ajax: base_url+'/su/pengembalian-dana/json',
        columnDefs: [
            {
                targets: 3,
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp. ' )
            },
        ],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'project.pembayaran.pin.pengajuan.nama_proyek', name: 'project.pembayaran.pin.pengajuan.nama_proyek' },
            { data: 'project.pembayaran.pin.pengajuan.client.user.name', name: 'project.pembayaran.pin.pengajuan.client.user.name' },
            { data: 'jmlh_pengembalian', name: 'jmlh_pengembalian' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


