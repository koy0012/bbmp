<h1 class='text-2xl mb-10'>{{$title}}</h1>

<div class='mb-5'>
    <button class='btn btn-sm btn-primary fn-select-all' module='user'>Select All</button>
    <button class='btn btn-sm btn-primary fn-delete-all' module='user'>Delete Selected</button>
    <a class='btn btn-sm btn-primary' href="{{ url('/back/user/create') }}">Add</a>

    
</div>
<table id="table" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>References</th>
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
            'module':'user',
            'columns': [
                { data: 'user_id', render: (data,type,row) => {
                    return `<input value='${data}' class='form-control multi-selection' module='user' type='checkbox'/>`;
                }}, 
                { data: 'name' },
                { data: 'email' }, 
                { data: 'position'}, 
                { data: 'user_id', render: (data,type,row) =>  {  
                    return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-24">
                        <li><a href='${BASE_URL}/back/user/${row['id']}/edit'>Update</a></li>
                        <li><a class='fn-delete-row' module='user' value='${row['id']}' ask='true'>Delete</a></li>
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
 