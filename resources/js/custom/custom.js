$(document).ready(function () {
    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    function deleteData(id, url) {
        // alert(url);
        $.ajax({
            url: url,
            type: "GET",
            data: { "genre_id": id, },
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status_code == 202) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                }
            }
        });
    }
});