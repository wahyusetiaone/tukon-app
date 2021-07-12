import Swal from "sweetalert2";

$(document).ready(function () {
    $("button").click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")){
            Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu akan menghapus item ini dari wishlist mu !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#F44336',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/client/wishlist/remove/"+data.val(),
                        type: "get",
                        success: function (response) {
                            Swal.fire(
                                'Terhapus!',
                                'Item telah terhapus.',
                                'success'
                            ).then((response)=>{
                                window.location.reload();
                            })
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    });
});
