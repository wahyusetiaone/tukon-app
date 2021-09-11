import Swal from 'sweetalert2';
import {base_url} from "./app";

$(document).on('click', '[id^=btn-send]', function (e) {
    e.preventDefault();
    $('#form-ajukan').submit();
    return false;
});
