<script>
    let REGION_ID = '{{$id}}';
    let ENCODER_ID = "{{$encoder['id'] ?? ''}}"; 
</script>

<div class='mb-5'>
    <h1 class='text-2xl'>{{$data['region']}}</h1>
    <h1 class='text-lg text-slate-700'>{{$title}}</h1>
</div>
<div class="overflow-auto lg:overflow-visible">
    <table id="table" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Province Head</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(() => {
        let table = new CustomDataTable({
            'id': '#table',
            'module': 'province',
            'config': (d) => {
                d.config = {
                    'region_id': REGION_ID
                };
            },
            'columns': [{
                    data: 'name',
                    render: (data, type, row) => {
                        let name = `<a class='text-blue-600' href='${BASE_URL}/back/municipal/${row['id']}/province'>${row['name']}</a>`;
                        return name ?? 'N/A';
                    }
                },
                {
                    data: 'province_head',
                    render: (data, type, row) => {
                        let name = 'N/A';

                        if (data != null) {
                            name = `<a class='text-blue-600' href='${BASE_URL}/back/user/${row['head_user_id']}'>${row['province_head']}</a>`;
                        }

                        return name;
                    }
                },
                {
                    data: 'province_id',
                    render: (data, type, row) => {
                        return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-36">
                      <li><a href='${BASE_URL}/back/province/manage/${row['id']}'>Manage</a></li> 
                      <li><a href='${BASE_URL}/back/municipal/${row['id']}/province'>Municipals</a></li> 
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