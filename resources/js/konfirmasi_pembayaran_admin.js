import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=btn-tolak]', function (e) {
    e.preventDefault();
    var data = $(this).val();
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin ingin menolak pembayaran ini ?',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-confirm').attr('action', base_url+'/admin/pembayaran/tolak/'+data);
            $('#form-confirm').submit();
        }
    });
    return false;
});

$(document).on('click', '[id^=btn-terima]', function (e) {
    e.preventDefault();
    var data = $(this).val();
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan mengkonfirmasi bahwa pembayaran ini berhasil ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-confirm').attr('action', base_url+'/admin/pembayaran/terima/'+data);
            $('#form-confirm').submit();        }
    });
    return false;
});
