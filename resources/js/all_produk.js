import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(function() {
    var table = $('#produk-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: base_url+'/produk/json',
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
        Swal.fire({
            icon: 'warning',
            text: 'Do you want to remove this?',
            showCancelButton: true,
            confirmButtonText: 'DELETE',
            confirmButtonColor: '#F44336',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url+'/produk/delete/'+ button.id,
                    type: "get",
                    success: function (response) {
                        if (response){
                            Swal.fire({
                                icon: 'success',
                                title: 'Delete item has been successfully !!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((response)=>{
                                location.reload();
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
});


