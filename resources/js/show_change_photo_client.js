import Swal from "sweetalert2";
import {base_url} from "./app";

$(document).ready(function () {
    $("#path_foto").on('change', function () {
        $('#divpreview').css('display','block');

        console.log("trigger")
        let reader = new FileReader();
        reader.onload = (e) => {
            $("#previewimg").attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
        return false;
    });
});
