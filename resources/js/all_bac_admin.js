import {base_url} from './app.js'
import Swal from "sweetalert2";

$(function () {
$('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true, searching: false,
        ajax: base_url + '/su/user/admin-cabang/bac/json',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'bac', name: 'bac'},
            {data: 'dibuat', name: 'dibuat', orderable: false, serachable: false, sClass: 'text-center'},
            {data: 'dinonactive', name: 'dinonactive', orderable: false, serachable: false, sClass: 'text-center'},
            {data: 'status', name: 'status', orderable: false, serachable: false, sClass: 'text-center'},
        ],
        "order": [[0, "desc"]]
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


$(document).on('click', '[id^=ganti-bac]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin akan mengubah BAC ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#fm-ganti-bpa').submit();
        }
    });
    return false;
});
