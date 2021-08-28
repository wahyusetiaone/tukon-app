import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: base_url+'/admin/penarikan-dana/json',
        columnDefs: [
            {
                targets: 3,
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp. ' )
            },
        ],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'penarikan_dana.project.pembayaran.pin.pengajuan.nama_proyek', name: 'penarikan.project.pembayaran.pin.pengajuan.nama_proyek' },
            { data: 'penarikan_dana.project.pembayaran.pin.tukang.user.name', name: 'penarikan.project.pembayaran.pin.tukang.user.name' },
            { data: 'penarikan', name: 'penarikan' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


