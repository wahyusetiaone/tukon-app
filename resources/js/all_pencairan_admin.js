import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        ajax: base_url+'/su/pencairan-bonus/json',
        columnDefs: [
            {
                targets: 3,
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp. ' )
            },
        ],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'bonus.project.pembayaran.pin.pengajuan.nama_proyek', name: 'bonus.project.pembayaran.pin.pengajuan.nama_proyek' },
            { data: 'bonus.admin.user.name', name: 'admin.user.name' },
            { data: 'bonus.bonus', name: 'bonus' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


