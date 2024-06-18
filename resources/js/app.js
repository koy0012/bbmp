import './bootstrap';
import 'flowbite'; 
import { generateFromEmail, generateUsername } from "unique-username-generator";

$("#region-select").select2({
    selectionCssClass: 'form-select',
    minimumInputLength: 1,
    language: {
        inputTooShort: function(args) { 
          return "Search Region";
        }
    },
    ajax: {
        url: `${BASE_URL}/regional/list`,
        data: function (params) {
            var query = {
                search: {
                    value: params.term
                }
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
        },
        processResults: (data, param) => {
            let arr = data.data.map(e => {
                return {
                    'id': e.id,
                    'text': e.name
                };
            });

            return {
                results: arr
            };
        }
    }
});

$("#provincial-select").select2({
    selectionCssClass: 'form-select',
    minimumInputLength: 1,
    language: {
        inputTooShort: function(args) { 
          return "Search Provincial";
        }
    },
    ajax: {
        url: `${BASE_URL}/provincial/list`,
        data: function (params) {
            var query = {
                search: {
                    value: params.term
                }
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
        },
        processResults: (data, param) => {
            let arr = data.data.map(e => {
                return {
                    'id': e.id,
                    'text': e.name
                };
            });

            return {
                results: arr
            };
        }
    }
}); 

$("#provincial-select").on('change', function (e) {
    $("#municipal-select").val(null).trigger("change");
});


$("#group-select").select2({
    selectionCssClass: 'form-select',
    ajax: {
        url: `${BASE_URL}/group/list`,
        data: function (params) {
            var query = {
                search: {
                    value: params.term
                },
                config: {
                    "region_id": $("#region-select").val() ?? $("#group-select").attr('data-region') ?? 0
                }
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
        },
        processResults: (data, param) => {
            let arr = data.data.map(e => {
                return {
                    'id': e.id,
                    'text': e.name
                };
            });

            return {
                results: arr
            };
        }
    }
});

$("#region-select").on('change', function (e) {
    $("#municipal-select").val(null).trigger("change");
    $("#provincial-select").val(null).trigger("change");
});


$("#municipal-select").select2({
    selectionCssClass: 'form-select',
    minimumInputLength: 1,
    language: {
        inputTooShort: function(args) { 
          return "Search Municipal";
        }
    },
    ajax: {
        url: `${BASE_URL}/municipal/list`,
        data: function (params) {
            var query = {
                config: {
                    "region_id": $("#region-select").val() ?? $("#region-select").attr('data-municipal') ?? 0,
                    "province_id": $("#provincial-select").val() ?? $("#provincial-select").attr('data-provincial') ?? 0
                },
                search: {
                    value: params.term
                }
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
        },
        processResults: (data, param) => {
            let arr = data.data.map(e => {
                return {
                    'id': e.id,
                    'text': e.name
                };
            });

            return {
                results: arr
            };
        }
    }
});

$("#municipal-select").on('change', function (e) {
    $("#barangay-select").val(null).trigger("change");
});


$(document).on('click', '.fn-open-qr', (e) => {
    var url = $(e.currentTarget).attr('data-content');
    var title = $(e.currentTarget).attr('data-title');

    makeModalQR(`-`, `This QR CODE is from<br>${title}`, url, () => { });
});

$(document).on('click', '.fn-clipboard', (e) => {
    let content = $(e.target).attr('data-content');

    navigator.clipboard.writeText(content);
    alert('link copied:' + content);
});
 

$("#barangay-select").select2({
    selectionCssClass: 'form-select', 
    minimumInputLength: 1,
    language: {
        inputTooShort: function(args) { 
          return "Search Barangay";
        }
    },
    ajax: {
        url: `${BASE_URL}/barangay/list`,
        data: function (params) {
            var query = {
                search: {
                    value: params.term
                },
                config: {
                    "municipal_id": $("#municipal-select").val() ?? $("#barangay-select").attr('data-municipal') ?? 0
                }
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
        },
        processResults: (data, param) => {
            let arr = data.data.map(e => {
                return {
                    'id': e.id,
                    'text': e.name
                };
            });

            return {
                results: arr
            };
        }
    }
});

$("textarea").each(function () {
    this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
    this.style.height = 0;
    this.style.height = (this.scrollHeight) + "px";
});

$(document).on('focusout',"[data-func='user-gen']", (ex) => {
    let username = $(ex.currentTarget).attr("data-target"); 
    let input = $(ex.currentTarget).val().trim().split(" ");
    
    if($(username).val().trim().length > 0) return;

    generateCustomUsername(username,input);
    
});

$(document).on('click',"[data-func='user-gen']", (ex) => {
    let username = $(ex.currentTarget).attr("data-target"); 
    let ref = $(ex.currentTarget).attr("data-ref"); 
    let input = $(ref).val().trim().split(" ");
    
    generateCustomUsername(username,input);
    
});

function generateCustomUsername(username,input){

    let firstname = input[0];
    let lastname = input[input.length - 1]; 

    lastname = lastname + Math.floor(Math.random() * 99).toString();
    let name = firstname + lastname;

    if(input.length == 1){
        name = firstname + Math.floor(Math.random() * 99).toString();;
    }

    if(name.length > 20){
        name = firstname.substring(0,1) + lastname;
    }

    if(name.length > 20){
         name = name.substring(0,20);
    }

    $(username).val(name.toLowerCase());
}

$(document).on("click", ".fn-verify-all", (e) => {
    var module = $(e.target).attr('module');

    var ids = [];

    $(`.multi-selection[module='${module}']`).each((i, obj) => {
        if ($(obj).prop('checked')) {
            ids.push(
                $(obj).attr('value')
            );
        }
    });

    if (ids.length == 0) {
        alert("Please select a member before proceeding");
        return;
    }

    var con = confirm(`You're about to verify & approve ${ids.length} member(s). Are you sure?`);
    if (!con) return;

    $.ajax({
        url: "/back/user/verifyAll/multiple",
        type: 'POST',
        data: { ids: ids },
        success: function (data) {
            if (data.success) {
                $(document).trigger("table:reload");
            }
        }
    })
});

