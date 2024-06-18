$(document).ready(() => {
    $(document).on('change', '.fn-img-change', (event) => {
        let output_id = event.target.getAttribute('data-output');
        let default_img = event.target.getAttribute('data-default');
        let href_id = event.target.getAttribute('data-href-id');
    
        var output = $(output_id);
    
        if (event.target?.files[0] != null) {
            output.attr('src', URL.createObjectURL(event.target.files[0]));
            $(href_id).attr('href', URL.createObjectURL(event.target.files[0]));
        } else {
            output.attr('src', default_img);
            $(href_id).attr('href', default_img);
        }
    
    
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    });
    
    $('.fn-img-change').trigger('change');
});