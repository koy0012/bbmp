 <?php
    $muncipal_url = '';

    if (!empty($municipal_id)) {
        $muncipal_url = "municipal_id=$municipal_id";
    }
    ?>

 <script>
     const MUNICIPAL_ID = '{{$municipal_id ?? ""}}';
     const BARANGAY_ID = '{{$barangay_id ?? ""}}';
     const ROLE = '{{$role ?? ""}}';
     const STATUS = '{{$status ?? ""}}';
 </script>


 <div class="mb-10">
     @if(!empty($municipal))
     <h1 class='text-2xl'>{{$municipal['region']}}, {{$municipal['name']}}</h1>
     @endif
     <h1 class='text-xl' perms='municipals'>{{$title}}</h1>
 </div>

 <div class='mb-5 flex items-center justify-normal lg:justify-between w-full flex-col lg:flex-row'>
     <div class="flex flex-col lg:flex-row text-center gap-3 w-full lg:items-center">
         <div class="flex items-center justify-center gap-1 flex-col lg:flex-row">
             <div class="flex gap-1">
                 <button class='btn btn-sm btn-primary fn-select-all' module='user'>Select All</button>
                 <button class='btn btn-sm btn-primary fn-verify-all' module='user'>Verify All</button>
             </div>
             <span class="hidden lg:block">|</span>
             <div class="flex items-center justify-center gap-1">
                 <a class='btn btn-sm btn-primary' href="{{ url('/back/user/create') }}?{{$muncipal_url}}">Add Member</a>
                 <div class="flex items-center">
                     <details class="dropdown">
                         <summary class="btn btn-sm btn-primary capitalize">Filtered By: {{empty($status) ? 'all' : $status}} </summary>
                         <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                             <li><a href="/back/user/filter">Show All</a></li>
                             <li><a href="/back/user/filter?status=pending&{{$muncipal_url}}">Pending</a></li>
                             <li><a href="/back/user/filter?status=approved&{{$muncipal_url}}">Approved</a></li>
                             <li><a href="/back/user/filter?status=banned&{{$muncipal_url}}">Banned</a></li>
                             <li><a href="/back/user/filter?status=restricted&{{$muncipal_url}}">Restricted</a></li>
                         </ul>
                     </details>
                 </div>
             </div>
         </div>

         @if(!empty($analytics['pending']))
         <a href="/back/user/filter?status=pending&municipal_id={{$municipal_id}}">
             <span class="bg-yellow-100 text-yellow-800 text-lg font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pending: {{$analytics['pending']}}</span>
         </a>
         @endif
     </div>
     @if(!empty($municipal_id))
     <div class="flex items-center">
         <a class='btn btn-sm btn-primary' href="/back/municipal/manage/{{$municipal_id}}">Manage Municipal</a>
     </div>
     @endif


 </div>
 <div class="lg:overflow-visible">
     <table id="table" class="display">
         <thead>
             <tr>
                 <th></th>
                 <th></th>
                 <th>Member</th>
                 <th>Registry</th>
                 <th>Sub Group</th>
                 <th>Role</th>
                 <th>State</th>
                 <th>Approve By</th>
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
             'misc': {
                 responsive: true
             },
             'id': '#table',
             'config': (d) => {
                 d.config = {
                     'municipal_id': MUNICIPAL_ID,
                     'barangay_id': BARANGAY_ID,
                     'role': ROLE,
                     'status': STATUS
                 }
             },
             'module': 'user',
             'columns': [{
                     data: 'user_id',
                     render: (data, type, row) => {
                         return "";
                     }
                 },
                 {
                     data: 'user_id',
                     render: (data, type, row) => {
                         return `<input value='${data}' class='form-control multi-selection' module='user' type='checkbox'/>`;
                     }
                 }, {
                     data: 'name',
                     render: (data, type, row) => {
                         return `<div>
                        <a class='text-blue-600' href='/back/user/${row['id']}'>${row['name']}</a><br>
                        <div class='text-sm text-slate-500'>${row['username']}<br></div>
                    </div>`;
                     }
                 },
                 {
                     data: 'region',
                     render: (data, type, row) => {

                         let encoder = `<a class='text-blue-600' href='/back/user/${row['encoded_by']}'>${row['encoder']}</a>`;
                         let municipal = `<a class='text-purple-900' href='/back/user/filter?municipal_id=${row['municipal_id']}&status=approved'>${row['region']}, ${row['municipal']}</a>`;

                         return `<div>
                        ${municipal}<br>
                        <div class='text-sm text-slate-500'>Encoder: ${row['encoder'] == null ? "<i>Self</i>" : encoder}<br></div>
                    </div>`;
                     }
                 },
                 {
                     data: 'sub_group_name',
                     className: 'capitalize'
                 },
                 {
                     data: 'role',
                     className: 'capitalize'
                 },
                 {
                     data: 'state',
                     className: 'capitalize'
                 },
                 {
                     data: 'approver',
                     render: (data, type, row) => {

                         let approver = `<a class='text-blue-600' href='/back/user/${row['approved_by']}'>${row['approver']}</a>`;

                         return `<div>
                        ${row['approver'] == null ? "N/A" : approver} 
                    </div>`;
                     }
                 },
                 {
                     data: 'user_id',
                     className: "all",
                     render: (data, type, row) => {
                         let hid_user_info = '';
                         if (row['info_id'] == null) {
                             hid_user_info = 'hidden'
                         }

                         let view_id = `<li><a  href='${BASE_URL}/back/valid_id/${row['id']}/id?v=${row['updated_at']}' target='_blank'>View ID</a></li>`;
                         let suspend = `<li class='fn-state' data-id='${row['id']}' data-state='banned'><a>Suspend</a></li>`;
                         if (row['state'] != "approved") {
                             view_id = "";
                             suspend = "";
                         }

                         let sub_group_title = "";
                         if (row['sub_group_name'] != "" && row['sub_group_name'] != null) {
                             row['sub_group_name'] = row['sub_group_name'].toUpperCase();
                             sub_group_title = `<br>Sub Group: ${row['sub_group_name']}`;
                         }

                         let show_qr = `<li><a class='fn-open-qr cursor-pointer' data-title="${row['name']}${sub_group_title}" data-content="/qrcode?url=${BASE_URL}/register/${row['municipal_id']}?ref=${row['id']}">
                  QR CODE
                </a></li>`;



                         return `<div><div class="dropdown dropdown-top dropdown-end">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-52 ">
                        ${view_id}
                        ${show_qr} 
                        </ul>
                    </div>
                    <div class="dropdown dropdown-top dropdown-end">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Profile</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-52 ">
                        <li><a href='${BASE_URL}/back/user/${row['id']}'>Review</a></li>
                        <li class='${hid_user_info}'><a href='${BASE_URL}/back/valid_id/${row['id'] ?? 0}'>Documents</a></li>
                        <li><a href='${BASE_URL}/back/user/${row['id']}/edit'>Update Account</a></li>
                        <li class='${hid_user_info}'><a href='${BASE_URL}/back/user_info/${row['id'] ?? 0}/edit'>Update Info</a></li>
                        <li class='${hid_user_info} hidden'><a href='${BASE_URL}/back/activity/${row['id'] ?? 0}'>Activity Log</a></li> 
                        ${suspend}
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


         $(document).on('click', '.fn-state', (e) => {
             let id = $(e.currentTarget).attr('data-id');
             let state = $(e.currentTarget).attr('data-state');

             let con = confirm("Suspend account?");

             if (!con) {
                 return;
             }

             $.ajax({
                 url: `${BASE_URL}/back/user/state`,
                 accepts: 'application/json',
                 method: 'POST',
                 data: {
                     id: id,
                     state: state
                 },
                 success: (e) => {
                     $(document).trigger("table:reload");
                 }
             });
         });

     });
 </script>