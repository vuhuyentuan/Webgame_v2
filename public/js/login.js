$(document).on('click', '#login', function(e) {
    e.preventDefault();
    $('div#login_modal').load($(this).attr('href'), function() {
        $(this).modal('show');
    });

    $('#login_modal').on('shown.bs.modal', function (e) {
        $(document).on('click', '#login_submit', function(e) {
            if ($('form#login_form').valid() == true) {
                $('#login_submit').attr('disabled', true)
                var url = $('form#login_form').attr('action');
                var data = $('form#login_form').serialize();
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        $('#login_submit').attr('disabled', false)
                        if(result.success == true){
                            $('#user-panel').html(`<a href=""><i class="fa fa-user-o" aria-hidden="true"></i> ${result.data.name}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/logout"><i class="fa fa-power-off"></i> ${logout}</a>`)
                            $('div#login_modal').modal('hide');
                            toastr.success(login_successfully);
                            if (result.data.role == 1) {
                                setTimeout(window.location = window.location.origin +'/dashboard', 2000);
                            }
                        }else{
                            toastr.error(result.msg)
                        }
                    }
                });
            }
        })
    });
});
