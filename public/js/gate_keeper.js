$(document).ready(() => {
    let PERMISSIONS = $("meta[name='maphatar']").attr('content'); 
    $('head').append(`<style id='css-maphatar'></style>`);

    let content = "[perms]{display:none;}";  

    let parse = JSON.parse(PERMISSIONS);

    for (var _module in parse) { 
        let m = parse[_module].split('.');

        if (m[1] == "*") {
            content += `[perms*='${m[0]}']{display:block;}`;
        } else {
            content += `[perms='${parse[_module]}']{display:block;}`;
        }
    }
    $('#css-maphatar').html(content);
}); 