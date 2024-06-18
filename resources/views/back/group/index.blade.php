<h1 class='text-2xl mb-10'>{{$title}}</h1>

<div class='mb-5'>
</div>

<div class="mb-5">
    <a class='btn btn-sm btn-primary' href="{{ url('/back/group/create') }}">Add Sub Group</a>
</div>
<table id="table" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Region</th>
            <th>Description</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    $(document).ready(() => {
        let table = new CustomDataTable({
            'id': '#table',
            'module': 'group',
            'columns': [{
                    data: 'name',
                    render: (data, type, row) => {
                        return `<div>
                        <a >${row['name']}</a><br>
                        <div class='text-sm text-slate-500'>${row['short_name']}<br></div>
                    </div>`;
                    }
                },
                {data:"region"},
                {
                    data: 'description',
                    render: (data, type, row) => {
                        return data ?? 'N/A';
                    }
                },
                {
                    data: 'region_id',
                    render: (data, type, row) => { 
                        return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-36">
                        <li><a href='${BASE_URL}/back/group/${row['id']}/edit'>Edit</a></li>
                        <li><a  class='fn-delete-row' module='group' value='${row['id']}' ask='true'>Disband</a></li> 
                      </ul>
                    </div>`;
                    }
                }
            ]
        }).init();


        $(document).on('table:reload', () => {
            table.ajax.reload(null, false);
            console.log("firing");
        });
    });
</script>