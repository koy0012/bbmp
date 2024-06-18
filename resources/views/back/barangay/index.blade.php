<script>
    let MUNICIPAL_ID = '{{$id}}';
    let ENCODER_ID = "{{$encoder['id'] ?? ''}}";
</script>

<div class='mb-5'>
    <h1 class='text-2xl'>{{$data['region']}}, {{$data['province']}}, {{$data['name']}}</h1>
    <h1 class='text-lg text-slate-700'>{{$title}}</h1>
</div>
@hasanyrole('national')
<div class="py-5 flex items-center gap-1 flex-col lg:flex-row">
    <details class="dropdown">
        <summary class="btn btn-sm btn-success">Share Municipal</summary>
        <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
            <li><a class='fn-open-qr' data-title="{{$data['region']}}, {{$data['name']}}" data-content="/qrcode?url={{url('/')}}/register/{{$id}}?ref={{$encoder['id']}}">Copy Share QR</a></li>
            <li><a class='fn-clipboard' data-content="{{url('/')}}/register/{{$id}}?ref={{$encoder['id']}}">Copy Share Link</a></li>
        </ul>
    </details>
    <a href="{{url('/')}}/back/municipal/manage/{{$id}}" class="btn btn-sm btn-success">Manage Municipal</a>
    <a href="{{url('/')}}/back/user/filter?municipal_id={{$id}}" class="btn btn-sm btn-success">Show Municipal Members</a>
</div>
@endhasanyrole
<div class="overflow-auto lg:overflow-visible">
    <table id="table" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Barangay Director</th>
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
            'module': 'barangay',
            'config': (d) => {
                d.config = {
                    'municipal_id': MUNICIPAL_ID
                };
            },
            'columns': [{
                    data: 'name',
                    render: (data, type, row) => {
                        let name = `${row['name']}`;
                        return name ?? 'N/A';
                    }
                },
                {
                    data: 'barangay_head',
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
                      <li><a href='${BASE_URL}/back/barangay/manage/${row['id']}'>Manage</a></li> 
                      <li perms='municipals.members'><a href="${BASE_URL}/back/user/filter?barangay_id=${row['id']}&status=approved">Members</a></li> 
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