import Swal from 'sweetalert2';
import {base_url} from './app.js'

$(function () {
    var a = location.href;
    var b = a.substring(a.indexOf("?") + 1);
    var query = "";

    const segments = new URL(a).pathname.split('/');
    const last = segments.pop() || segments.pop(); // Handle potential trailing slash

    if (last === 'tukang') {
        query = "tukang/json?";
    } else if (last === 'klien') {
        query = "klien/json?";
    } else if (last === 'admin-cabang') {
        query = "admin-cabang/json?";
    }

    if (a.indexOf('?') > -1) {
        query += b;
        var url = new URL(a);
        var c = url.searchParams.get("query");
        $('#query').val(c);
    }
    if (last === 'admin-cabang') {
        $('#produk-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": true, searching: false,

            ajax: base_url + '/su/user/' + query,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'email', name: 'email'},
                {data: 'link', name: 'link', orderable: false, serachable: false, sClass: 'text-center'},
                {data: 'status', name: 'status', orderable: false, serachable: false, sClass: 'text-center'},
                {data: 'action', name: 'action', orderable: false, serachable: false, sClass: 'text-center'},
            ]
        });
    } else {
        $('#produk-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": true, searching: false,

            ajax: base_url + '/su/user/' + query,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status', orderable: false, serachable: false, sClass: 'text-center'},
            ]
        });
    }

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

