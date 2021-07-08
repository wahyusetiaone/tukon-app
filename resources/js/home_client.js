import Swal from "sweetalert2";

$(document).ready(function () {
    $("button").click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")){
            Swal.fire({
                icon: 'question',
                text: 'Apakah kamu ingin menambahkan di wishlist mu?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya',
                confirmButtonColor: '#2196F3',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/client/wishlist/add/"+data.val(),
                        type: "get",
                        success: function (response) {
                            data.removeClass("bg-failure");
                            data.addClass("bg-secondary");
                            data.addClass("disabled");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    });
});
