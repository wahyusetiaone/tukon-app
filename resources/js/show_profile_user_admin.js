import Swal from "sweetalert2";
import {base_url} from "./app";

$(document).on('click', '[id^=btn_banned]', function (e) {
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
            Swal.fire({
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your message here...',
                showCancelButton: true,
                inputAttributes: {
                    'aria-label': 'Type your message here'
                },preConfirm: (textValue) => {
                    if (textValue === "") {
                        return Swal.showValidationMessage(
                            'Catatan tidak boleh kosong'
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((resultt) => {
                $('input[name="reason"]').val(resultt.value)
                $('#frm-banned').submit();
            })
        }
    });
    return false;
});

$(document).on('click', '[id^=btn_unbanned]', function (e) {
    e.preventDefault();
    var idU = $(this).val();
    Swal.fire({
        icon: 'question',
        text: 'Apakah yakin ingin unbanned akun ini ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#03A9F4',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url+"/admin/user/unbanned/"+idU,
                type: "get",
                success: function(data){
                    Swal.fire(
                        'Successfuly !',
                        'Berhasil melakukan unbanned account !',
                        'success'
                    ).then((res) =>{
                        location.reload();
                    })
                },
                error: function(error){
                    Swal.fire(
                        'Error !',
                        error,
                        'success'
                    )
                }
            });
        }
    });
    return false;
});
