import Swal from 'sweetalert2';
import { base_url } from './app.js'

$(document).on('click', '[id^=btn_cancle_proyek]', function (e) {
    e.preventDefault();
    var data = $(this).val();
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin ingin membatalkan proyek ini ?',
        showCancelButton: true,
        confirmButtonText: 'Batal',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#batal-form-'+data).submit();
        }
    });
    return false;
});

