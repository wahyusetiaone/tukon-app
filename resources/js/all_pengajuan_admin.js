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
        processing: true,
        serverSide: true,
        ajax: base_url+'/admin/pengajuan/json'+query,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama_proyek', name: 'pin.pengajuan.nama_proyek' },
            { data: 'client.user.name', name: 'pin.tukang.user.name' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

