import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=tolak-btn]', function () {
    var data = $(this);
    Swal.fire({
        input: 'textarea',
        inputLabel: 'Catatan Penolakan Penawaran !',
        inputPlaceholder: 'Catatan untuk tukang ...',
        inputAttributes: {
            'aria-label': 'Type your message here'
        },
        showCancelButton: true,
        preConfirm: (textValue) => {
            if (textValue === "") {
                return Swal.showValidationMessage(
                    'Catatan tidak boleh kosong'
                )
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + '/client/persetujuan/revisi/' + data.val() + '/' + result.value,
                type: "get",
                success: function (response) {
                    if (response) {
                        if (response.data.update_status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item has been rejected successfully !!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((response) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something error, contact the Administrator !!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((response) => {
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    })
    return false;
});

$(document).on('click', '[id^=terima-btn]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan menyetujui penawaran ini?',
        showCancelButton: true,
        confirmButtonText: 'Setuju',
        confirmButtonColor: '#4CAF50',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + '/client/persetujuan/accept/' + data.val(),
                type: "get",
                success: function (response) {
                    if (response) {
                        if (response.data.update_status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item has been approved successfully !!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((response) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something error, contact the Administrator !!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((response) => {
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });
    return false;
});
