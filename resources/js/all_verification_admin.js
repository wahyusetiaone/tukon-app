import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        ajax: base_url+'/su/verification-tukang/json',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'tukang.user.name', name: 'tukang.user.name' },
            { data: 'admin.user.name', name: 'admin.user.name' },
            { data: 'tukang.kota', name: 'tukang.kota' },
            { data: 'status', name: 'status', orderable:false, serachable:false, sClass:'text-center'},
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });
});


