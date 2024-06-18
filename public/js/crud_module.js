

// BASE_URL is declared outside of scope. 
let def_cm_config = {
    'crud': {
        'deleteAll': (module) => `${BASE_URL}/${module}/deleteAll`,
        'delete': (module, value) => `${BASE_URL}/${module}/delete`,
        'getList': (module) => `${BASE_URL}/${module}/getList`
    }
};

$(document).on("click", ".fn-delete-all", (e) => {
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
        alert("Please select a row before proceeding");
        return;
    }

    var con = confirm(`You're about to delete ${ids.length} row(s) of data. Are you sure?`);
    if (!con) return;

    $.ajax({
        url: def_cm_config.crud.deleteAll(module),
        type: 'DELETE',
        data: { ids: ids },
        success: function (data) {
            if (data.success) {
                $(document).trigger("table:reload");
            }
        }
    })
});

$(document).on("click", ".fn-delete-row", (e) => {
    var module = $(e.target).attr('module');
    var value = $(e.target).attr('value');
    var ask = $(e.target).attr('ask');

    if (ask != undefined) {
        let proceed = confirm("delete row?");
        if (!proceed) return;
    }

    $.ajax({
        url: def_cm_config.crud.delete(module, value),
        type: 'DELETE',
        data: { id: value },
        success: function (data) {
            if (data.success) {
                $(document).trigger("table:reload");
            }
        }
    })
}); 

$(document).on('click', '.fn-select-all', (e) => {
    var module = $(e.target).attr('module');
    var selected = $(e.target).attr('selected');
    if (selected == undefined) {
        $(e.target).attr('selected', true);
        selected = true;
    } else {
        selected = !selected;
        $(e.target).attr('selected', selected);
    }

    $(`.multi-selection[module='${module}']`).each((i, obj) => {
        $(obj).prop('checked', selected);
    });
});

class CustomDataTable {

    /*
    * @params
    * id - table id
    * module 
    * columns : same as datatable column format
    */

    constructor(params) {
        this.params = params;
    }

    init() {
        var params = this.params;

        $(document).on("preInit.dt", function () {
            $(".dataTables_filter input[type='search']").attr("maxlength", 25); 
        });

        let config = {
            ordering: false,
            ajax: {
                "url": def_cm_config.crud.getList(params.module),
                "data": function (d) {
                    if (!params.hasOwnProperty('config')) return;
                    params?.config(d);
                }
            },
            processing: true,
            serverSide: true,
            columns: params.columns,
            ...this.params.misc ?? {}
        }; 

        if (params.hasOwnProperty('language')) {
            config['language'] = params.language;
        }

        let table = $(params.id).DataTable(config);

        $(document).on("table:reload", (e) => {
            table.ajax.reload(null, false);
            $('.fn-select-all').attr('selected',false);
        });

        return table;
    }
}