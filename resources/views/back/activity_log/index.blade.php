<script>
    let USER_ID = "{{$id ?? ''}}";
</script>

<div class='mb-5'>
    <h1 class='text-2xl'>Activity Log</h1>
    <h1 class='text-lg text-slate-700'>{{$title}}</h1>
</div>
<div class="overflow-auto lg:overflow-visible">
    <table id="table" class="display">
        <thead>
            <tr>
                <th>Log</th> 
                <th>Date</th>
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
            'module': 'activity',
            'config': (d) => {
                d.config = {
                    user_id: USER_ID
                };
            },
            'columns': [{
                    data: 'log',
                    render: (data, type, row) => {
                        let log = data.replace(':modifier', row.modifier_name);
                        log = log.replace(':user', row.name);

                        return `<div>
                        <p>${log}</p>
                        <p class='text-sm text-slate-400'>${row['changes'] ?? ''}</p>
                        </div>`
                    }
                }, 
                {
                    data: 'created_at',
                    render: (data, type, row) => {
                        let date = new Date(data);
                        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
                    }
                }
            ]
        }).init();


        $(document).on('table:reload', () => {
            table.ajax.reload(null, false);
        });
    });
</script>