import Swal from 'sweetalert2';
import {base_url} from './app.js'

$(function () {
    var table = $('#produk-table').DataTable({
        columnDefs: [
            {
                targets: [2, 3, 4, 5],
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp. ')
            },
        ],
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: base_url + '/penarikan-dana/json',
        columns: [
            {data: 'id', name: 'id'},
            {
                data: 'project.pembayaran.pin.pengajuan.nama_proyek',
                name: 'project.pembayaran.pin.pengajuan.nama_proyek'
            },
            {data: 'total_dana', name: 'total_dana'},
            {data: 'limitasi', name: 'limitasi'},
            {data: 'penarikan', name: 'penarikan'},
            {data: 'sisa_penarikan', name: 'sisa_penarikan'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, serachable: false, sClass: 'text-center'},
        ]
    });
});


