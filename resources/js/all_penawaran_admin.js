import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var a = location.href;
    var b = a.substring(a.indexOf("?")+1);
    var query = "";
    if (a.indexOf('?') > -1)
    {
        query = "?"+b;
        var url = new URL(a);
        var c = url.searchParams.get("query");
        $('#query').val(c);
    }
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true, searching: false,
        ajax: base_url+'/su/penawaran/json'+query,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'pin.pengajuan.nama_proyek', name: 'pin.pengajuan.nama_proyek' },
            { data: 'pin.tukang.user.name', name: 'pin.tukang.user.name' },
            { data: 'pin.pengajuan.client.user.name', name: 'pin.pengajuan.client.user.name' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

