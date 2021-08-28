import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=btn-tolak-send]', function (e) {
    e.preventDefault();
    $('#form-confirm-tolak').submit();
    return false;
});

$(document).on('click', '[id^=btn-terima-send]', function (e) {
    e.preventDefault();
    $('#form-confirm-terima').submit();
    return false;
});
