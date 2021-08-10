import Swal from "sweetalert2";
import {base_url} from "./app";

$(document).ready(function () {
    $("#btnKonfirmasiSelesaiProyek").click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")) {

            Swal.fire({
                icon: 'warning',
                text: 'Pastikan kamu telah mengecek keseluruhan projek, sesudah anda melakukan konfirmasi uang akan langsung di transfer ke rekening tukang dan aplikasi tidak lagi bertanggung jawab?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya',
                confirmButtonColor: '#2196F3',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = base_url + "/client/project/approve/" + data.val();
                }
            });
        }
    });
});
