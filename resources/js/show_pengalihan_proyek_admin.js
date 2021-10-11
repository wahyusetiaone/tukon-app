import Swal from "sweetalert2";
import {base_url} from "./base_url";

var idTarget = 0;

$('#modalCariTukang').on('shown.bs.modal', function (e) {
    $('#results').empty();
    $('#search_penyedia_jasa').val("");
    idTarget =  $(e.relatedTarget).data('id');
})

$(document).on('click', '[id^=btn_cari_jasa]', function (e) {
    var query = $('#search_penyedia_jasa').val();
    if (query !== null || query !== ''){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: base_url+"/su/user/tukang/pengalihan-proyek/cari/penyedia-jasa/"+query,
            success: function(data) {
                $('#results').empty();
                data.forEach((entry) => {
                    var r= $('<button type="button" class="list-group-item list-group-item-action" name="pilihanTepat" value="'+entry.id+'">'+entry.user.name+'</button>');
                    $("#results").append(r);
                });
            }
        });
    }
    return false;
});

$(document).on('click', '[name^=pilihanTepat]', function (e) {
    $('#id_penyedia_jasa_'+idTarget).val($(this).val())
    $('#nama_penyedia_jasa_'+idTarget).val($(this).text())
    idTarget = 0;
    $(".modal-fade").modal("hide");
    $(".modal-backdrop").remove();
    $("#modalCariTukang .close").click()
    return false;
});


$(document).on('click', '[id^=kirim_pengalihan_proyek]', function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    Swal.fire({
        icon: 'warning',
        text: 'Apakah yakin ingin banned akun ini ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            var hasNull = false;
            $('input[name^="nama_penyedia_jasa"]').each(function() {
                if ($(this).val() === ''){
                    hasNull = true;
                }
            });

            if (!hasNull){
                $('#form-pengalihan-proyek').submit();
            }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Penyedia Jasa penganti wajib dipilih !',
                })
            }
        }
    });
    return false;
});
