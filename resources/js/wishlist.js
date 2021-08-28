import Swal from "sweetalert2";
import {base_url} from "./app";

$(document).ready(function () {
    var wishcount = 0;
    var datawish = [];
    $('button[name="btn_remove_wishlist"]').click(function () {
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
    $('button[name="send_pengajuan"]').click(function () {
        var data = $(this);
        window.location = "/client/pengajuan/form/"+data.val();
    });
    $('input[name^="wish"]').on('change',function (e) {
        console.log('am i');
        wishcount++;
        $('#count').html(wishcount);
        $('input[name^="wish"]:checked').each(function()
        {
            if (!datawish.includes($(this).val())){
                datawish.push($(this).val())
            }
        });
        console.log(datawish);
    });
    $('a[name="send-multi"]').click(function () {
        var url = '';
        datawish.forEach(function(item, index) {
            if (url === ''){
                url += item;
            }else {
                url += '_'+item;
            }
        });
        window.location = base_url+'/client/pengajuan/form/'+url;
    });
});
