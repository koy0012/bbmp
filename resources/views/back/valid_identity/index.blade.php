<h1 class='text-2xl mb-10'>{{$title}}</h1>

<div class='mb-5'>
    <button class='btn btn-sm btn-primary fn-select-all' module='user'>Select All</button>  
</div>
<table id="table" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Member</th>
            <th>Document</th> 
            <th></th> 
        </tr>
    </thead>
    <tbody> 
    </tbody>
</table>

<script>
    $(document).ready(()=> { 
        let table = new CustomDataTable({
            'id':'#table',
            'module':'valid_id',
            'columns': [
                { data: 'user_id', render: (data,type,row) => {
                    return `<input value='${data}' class='form-control multi-selection' module='user' type='checkbox'/>`;
                }}, 
                { data: 'name'},
                { data: 'no', render: (data,type,row) =>  { 
                    return `<div>
                        ${row['type_name']}<br>
                        ${row['no']}
                    </div>`;
                }}, 
                { data: 'user_id', render: (data,type,row) =>  {    
                    let hid_user_info = '';
                    if(row['info_id'] == null){
                        hid_user_info = 'hidden'
                    }

                    return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-36">
                        <li><a href='${BASE_URL}/back/valid_id/${row['id']}/edit'>Update</a></li>
                        <li><a id="valid-id-2h" href="${row['image']}" data-lightbox="image-1" data-title="${row['no']} - ${row['name']}">View</a></li> 
                      </ul>
                    </div>`;
                }}
            ]
        }).init();
        
        
        $(document).on('table:reload',() => {
            table.ajax.reload(null,false);
            console.log("firing");
        }); 
    });  
</script> 
 