import Swal from 'sweetalert2';
$(document).on('click', '[id^=btn-sub]', function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    Swal.fire({
        icon: 'question',
        text: 'Do you want to save this?',
        showCancelButton: true,
        confirmButtonText: 'Save it',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-edit-produk').submit();
        }
    });
    return false;
});
