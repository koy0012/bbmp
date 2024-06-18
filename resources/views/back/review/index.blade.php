<h1 class='text-2xl mb-10'>{{$title}}</h1>

<div class='mb-5'>
    <a class='btn btn-sm btn-primary' href="{{ url('/back/region/create') }}">Add</a>

    
</div>
<table id="table" class="display">
    <thead>
        <tr> 
            <th>Name</th> 
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
            'module':'region',
            'columns': [ 
                { data: 'name' }, 
                { data: 'region_id', render: (data,type,row) =>  {  
                    return `<div class="dropdown">
                      <div tabindex="0" role="button" class="btn btn-sm m-1">Action</div>
                      <ul tabindex="0" class="dropdown-content z-[1] menu px-2 shadow bg-base-100 rounded-box w-24">
                        <li><a href='${BASE_URL}/back/region/${row['id']}/edit'>Update</a></li>
                        <li><a class='fn-delete-row' module='region' value='${row['id']}' ask='true'>Delete</a></li>
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
 