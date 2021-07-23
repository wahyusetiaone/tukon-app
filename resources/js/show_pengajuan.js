import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=tolak-btn]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin akan menolak penawaran ini?',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url+'/pengajuan/tolak/'+ data.val(),
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
    return false;
});
