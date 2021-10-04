import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=tolak_]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin akan menolak verifikasi untuk tukang ini?',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                input: 'textarea',
                inputLabel: 'Catatan Penolakan Verifikasi Akun Tukang!',
                inputPlaceholder: 'Catatan untuk Admin Cabang ...',
                inputAttributes: {
                    'aria-label': 'Type your message here'
                },
                showCancelButton: true,
                preConfirm: (textValue) => {
                    if (textValue === "") {
                        return Swal.showValidationMessage(
                            'Catatan tidak boleh kosong'
                        )
                    }else {
                        $('#catatan').val(textValue);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#tolak-form').submit();
                }
            });
        }
    });
    return false;
});

$(document).on('click', '[id^=verifikasi_]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan memverifikasi tukang ini?',
        showCancelButton: true,
        confirmButtonText: 'Setuju',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#verifikasi-form').submit();
        }
    });
    return false;
});
