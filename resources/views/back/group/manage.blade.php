<script>
    let DATA_ID = "{{$id}}";
    let MUNICIPAL_NAME = "{{$data['name']}}";
    let MUNICIPAL_HEAD_ID = "{{$head['id'] ?? ''}}"
</script>
<div class="mb-10">
    <h1 class='text-2xl'>{{$data['region']}}, {{$data['name']}}</h1>
    <p class="text-slate-700">{{$title}}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="grid grid-cols-1 gap-4 h-fit">
        @if(!empty($head))
        <div class="app-plate">
            <div class="mb-5">
                <p class="text-lg">{{$head['name']}}</p>
                <p class="text-slate-700">Municipal Head</p>
            </div>
            <div class="flex items-center mb-3">
                <div>
                    <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 4a2.6 2.6 0 0 0-2 .9 6.2 6.2 0 0 0-1.8 6 12 12 0 0 0 3.4 5.5 12 12 0 0 0 5.6 3.4 6.2 6.2 0 0 0 6.6-2.7 2.6 2.6 0 0 0-.7-3L18 12.9a2.7 2.7 0 0 0-3.8 0l-.6.6a.8.8 0 0 1-1.1 0l-1.9-1.8a.8.8 0 0 1 0-1.2l.6-.6a2.7 2.7 0 0 0 0-3.8L10 4.9A2.6 2.6 0 0 0 8 4Z" />
                    </svg>
                </div>
                <div class="pl-2">
                    <p class="">{{$head['contact_number']}}</p>
                    <p class="text-sm text-slate-700">Contact Number</p>
                </div>
            </div>
            <div class="flex items-center mb-3">
                <div>
                    <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16v-5.5C11 8.5 9.4 7 7.5 7m3.5 9H4v-5.5C4 8.5 5.6 7 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1" />
                    </svg>
                </div>
                <div class="pl-2">
                    <p class="">{{$head['email']}}</p>
                    <p class="text-sm text-slate-700">Email</p>
                </div>
            </div>
            <div class="flex items-start">
                <div>
                    <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11.3 3.3a1 1 0 0 1 1.4 0l6 6 2 2a1 1 0 0 1-1.4 1.4l-.3-.3V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3c0 .6-.4 1-1 1H7a2 2 0 0 1-2-2v-6.6l-.3.3a1 1 0 0 1-1.4-1.4l2-2 6-6Z" clip-rule="evenodd" />
                    </svg>

                </div>
                <div class="pl-2">
                    <p class="mt-1">{{$head['address']}}</p>
                </div>
            </div>
        </div>
        @else
        <div class="app-plate">
            <div class="mb-5">
                <p class="text-lg">N/A</p>
                <p class="text-slate-700">Municipal Head</p>
            </div>

            <p class="text-sm text-slate-700">Additional information is not available. To appoint a municipal head, please select from the list of managers.</p>
        </div>
        @endif
        <div class="app-plate">
            <h1 class="text-lg mb-2">Municipal Activity Log</h1>
            <div class="grid grid-col-1 gap-2 mb-2">
                <div class="bg-gray-100 p-2 rounded-lg">
                    <div class="">
                        New Municipal Leader Assigned
                    </div>
                </div>
                <div class="bg-gray-100 p-2 rounded-lg">
                    <div class="">
                        New Municipal Leader Assigned New Municipal Leader Assigned
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-2">
            <div class="flex justify-end">
                <a href="#" class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    More Logs
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2 ">
        <div class="app-plate overflow-auto">
            <table id="table">
                <thead>
                    <tr>
                        <th>Managers</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
<script>
    $(document).ready(() => {
        let table = new CustomDataTable({
            'id': '#table',
            'module': 'user',
            'language': {
                'emptyTable': `No managers assigned. Ask the national officer to add one municipal officer here.`
            },
            'config': (d) => {
                d.config = {
                    role: 'municipal',
                    municipal_id: DATA_ID
                }
            },
            'columns': [{
                    data: 'name',
                    render: (data, type, row) => {
                        return `<div>
                        ${row['name']}<br>
                        <div class='text-sm text-slate-500'>${row['email']}<br></div>
                    </div>`;
                    }
                },
                {
                    data: 'user_id',
                    render: (data, type, row) => {
                        let hid_user_info = '';
                        if (row['info_id'] == null) {
                            hid_user_info = 'hidden'
                        }

                        if(MUNICIPAL_HEAD_ID == row['id']) return '';

                        return `<div  perms='municipals.assign_head'><div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-40">
                        <li><a class='fn-assign-head' data-id='${row['user_id']}' data-name='${row['name']}'>Assign as Head</a></li> 
                      </ul>
                    </div></div>`;
                    }
                }
            ]
        }).init();

        $(document).on('table:reload', () => {
            table.ajax.reload(null, false);
            console.log("firing");
        });

        let is_sending = false;

        $(document).on('click', '.fn-assign-head', (e) => {
            var name = $(e.target).attr('data-name');
            var id = $(e.target).attr('data-id');

            if (is_sending) return;


            makeModal(`assign-head`, `Assign "${name}" as head of ${MUNICIPAL_NAME} MUNICIPAL?`, () => {
                is_sending = true;
                $.ajax({
                    type: 'PUT',
                    url: `${BASE_URL}/back/municipal/${DATA_ID}`,
                    data: {
                        head_user_id: id
                    },
                    success: (e) => {
                        location.reload();
                    },
                    complete: () => {
                        is_sending = false;
                    }
                });
            }, () => {

            });



        });
    });
</script>