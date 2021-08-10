// import Swal from 'sweetalert2';
// import {base_url} from "./app";
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
// $(document).on('click', '[id^=btn_btll]', function (e) {
//     e.preventDefault();
//     var data = $(this).serialize();
//     Swal.fire({
//         icon: 'warning',
//         text: 'Apakah kamu ingin membatalkan pembayaran ini ?',
//         showCancelButton: true,
//         confirmButtonText: 'Batal',
//         confirmButtonColor: '#F44336',
//     }).then((result) => {
//         // if (result.isConfirmed) {
//         //     $('#form-edit-produk').submit();
//         // }
//     });
//     return false;
// });
