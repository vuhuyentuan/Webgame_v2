$(document).on('click', '.support_system', function () {
    $('a.support_system').removeClass('active')
    $(this).addClass('active');
    let system = $(this).attr('data-system')
    $.ajax({
        method: 'GET',
        url: '/',
        dataType: 'json',
        data: {
            system: system
        },
        success: function(result) {
            if(result == ''){
                $('#product_new_content').html(`<h5 class="text-white">${no_results_found} </h5>`);
            }else{
                $('#product_new_content').html(result);
            }

        }
    });
})
