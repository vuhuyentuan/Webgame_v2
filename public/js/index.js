window.setInterval(function() {
    if($(document).find('button.owl-dot.active').nextAll('button.owl-dot:first').length == 0){
        $('button.owl-dot')[0].click()
    }else{
        $(document).find('button.owl-dot.active').nextAll('button.owl-dot:first').click()
    }
}, 5000)
