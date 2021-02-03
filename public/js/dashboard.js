function deleteConfirmation(url) {
    swal.fire({
        title: "Delete data",
        text: "Are you sure you want to delete data?",
        icon: 'warning',
        showCancelButton: !0,
        cancelButtonText: "cancel",
        confirmButtonText: "delete",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'GET',
                url: url,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    if (results.success === true) {
                        swal.fire("Done!", results.message, "success").then(function (e){
                          if (e.value === true){
                              window.location.reload();
                          }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            e.dismiss;
        }

    }, function (dismiss) {
        return false;
    })
}


$(document).ready(function() {
    $('#style_data').DataTable( {
      "searching": false,
      "ordering": false,
    } );

    $(document).on("click", ".browse", function() {
        
        var file = $(this).parents().find(".file");console.log(file);
        file.trigger("click");
      });
      $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
    
        var reader = new FileReader();
        reader.onload = function(e) {
          // get loaded data and render thumbnail.
          document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
      });
});

