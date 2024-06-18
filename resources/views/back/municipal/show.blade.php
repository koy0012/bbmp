<script>
    let REGION_ID = '{{$id}}';
    let ENCODER_ID = "{{$encoder['id'] ?? ''}}";
    let PROVINCE_ID = "{{$province_id ?? ''}}";
</script>
<div class=" mb-10">
    <h1 class='text-2xl'>{{$data['region']}}, {{$data['name']}}</h1>
    <h1 class='text-lg text-slate-700'>{{$title}}</h1>
</div>

<div class='mb-5'>
</div>
<div class="overflow-auto lg:overflow-visible">
    <table id="table" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Municipal Head</th>
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
            'module': 'municipal',
            'config': (d) => {
                d.config = {
                    'region_id': REGION_ID,
                    'province_id': PROVINCE_ID
                };
            },
            'columns': [{
                    data: 'name',
                    render: (data, type, row) => {
                        let municipal = `<a class='text-blue-600' href="${BASE_URL}/back/barangay/${row['id']}">${row['name']}</a>`;
                        return municipal;
                    }
                },
                {
                    data: 'municipal_head',
                    render: (data, type, row) => {
                        return data ?? 'N/A';
                    }
                },
                {
                    data: 'region_id',
                    render: (data, type, row) => { 
                        return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-56">
                      <li><a class='fn-open-qr' data-title='${row['name']}' data-content='/qrcode?url=${BASE_URL}/register/${row['id']}?ref=${ENCODER_ID}'>Copy Share QR</a></li>
                      <li><a class='fn-clipboard' data-content='${BASE_URL}/register/${row['id']}?ref=${ENCODER_ID}'>Copy Share Link</a></li>
                      <li><a href="${BASE_URL}/back/municipal/manage/${row['id']}">Manage</a></li>
                      <li perms='municipals.members'><a href="${BASE_URL}/back/user/filter?municipal_id=${row['id']}&status=approved">Members</a></li> 
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