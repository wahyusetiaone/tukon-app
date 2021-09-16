import Swal from 'sweetalert2';
import {base_url} from "./app";
//
// $(document).on('click', '[id^=btn_bayar]', async function (e) {
//     e.preventDefault();
//     var data = $(this);
//     const {value: file} = await Swal.fire({
//         title: 'Upload bukti pembayaran',
//         input: 'file',
//         inputAttributes: {
//             'accept': 'image/*',
//             'aria-label': 'Upload bukti pembayaran'
//         }
//     })
//
//     const {value: text} = await Swal.fire({
//         input: 'textarea',
//         inputLabel: 'Note',
//         inputPlaceholder: 'Note anda...',
//         inputAttributes: {
//             'aria-label': 'Note anda'
//         },
//         showCancelButton: true
//     })
//
//     if (file && text) {
//         const reader = new FileReader()
//         reader.onload = (e) => {
//             Swal.fire({
//                 title: 'Konfirmasi bukti pembayaran',
//                 text: text,
//                 imageUrl: e.target.result,
//                 imageAlt: 'The uploaded picture',
//             }).then((result) => {
//                 jQuery.ajax({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                     url: base_url + '/client/pembayaran/pay/' + data.val(),
//                     data: {
//                         // 'path_transaksi': file,
//                         'note_transaksi': text
//                     },
//                     contentType:'application/x-www-form-urlencoded',
//                     processData: false,
//                     method: 'POST',
//                     success: function (data) {
//                         console.log(data);
//                     }
//                 });
//             })
//         }
//         reader.readAsDataURL(file)
//     }
//     return false;
// });
//
var mode = $('input[type="radio"]').val();

$(document).ready(function () {
    if (mode === 'offline') {
        $('#channel').prop('disabled', true)
    } else {
        $('#channel').prop('disabled', false)
    }

    $('input[type="radio"]').change(function () {
        if ($(this).val() === 'offline') {
            mode = 'offline';
            $('#channel').prop('disabled', true)
        } else {
            mode = 'online';
            $('#channel').prop('disabled', false)
        }
    });
});

$(document).on('click', '[id^=btn_btll]', function (e) {
    e.preventDefault();
    var data = $(this).val();
    Swal.fire({
        icon: 'warning',
        text: 'Apakah kamu ingin membatalkan pembayaran ini ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/client/pembayaran/batal/" + data,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.data.status) {
                        Swal.fire(
                            'Pembatalan Pembayaran Berhasil !',
                            data.data.message,
                            'success'
                        ).then((result) => {
                            window.location.href = base_url + '/client/pembayaran'
                        });
                    } else {
                        Swal.fire(
                            'Pembatalan Pembayaran Gagal     !',
                            data.data.message,
                            'success'
                        ).then((result) => {
                            window.location.href = base_url + '/client/pembayaran'
                        });
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        }
    });
    return false;
});
$(document).on('click', '[id^=btn_checkout]', function (e) {
    e.preventDefault();
    var data = $(this).val();
    var text = ' Anda akan melakukan pembayaran dengan metode '
    if (mode === 'offline'){
        text += 'OFFLINE(Manual).'
    }else {
        var channel = $('#channel').val();
        text += channel.toUpperCase();
    }
    console.log(mode);
    Swal.fire({
        icon: 'warning',
        text: 'Apakah kamu checkout pembayaran pesanan ini ?'+text,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed){
            $('form[name="fcm-up"]').submit();
        }
    });
    return false;
});
