$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: 'produk/json',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama_produk', name: 'nama_produk' },
            { data: 'range_min', name: 'range_min' },
            { data: 'range_max', name: 'range_max' },
            { data: 'action', name: 'action', orderable:false, serachable:false, sClass:'text-center'},
        ]
    });

    $('#produk-table tbody').on('click', 'td button[name="delete"]', function (event){
        var button = event.target;
        console.log("hay"+button.id);
    });
});


