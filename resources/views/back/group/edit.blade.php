  
 <script>
     let DATA_ID = '{{$id}}';
 </script>
 <div class='w-3/4 mx-auto'>
     <h1 class='text-2xl mb-5'>{{$title}}</h1>

     <form class='fn-create-form' id='main-form'>
        <input type="hidden" name="_method" value="PUT">
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-4"> 
             <div class='input-group'>
                 <label for="name">Name</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' value="{{$data['name']}}" name='name' type="text" required />
                 </div>
             </div>
             <div class='input-group'>
                 <label for="name">Short Name</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' value="{{$data['short_name']}}" name='short_name' type="text" placeholder="Short names are used in IDs" required />
                 </div>
             </div>
             <div class='input-group'>
                 <label for="name">Description</label>
                 <div class='input-subgroup'>
                     <textarea name="description" id="" cols="30" rows="10" class="input input-bordered w-full h-44">{{$data['description']}}</textarea>
                 </div>
             </div>
         </div>

         <div class='flex justify-end'>
             <button class='btn btn-primary fn-create-submit' type='submit'>
                 Confirm
             </button>
         </div>
     </form>
 </div>

 <script>
     $(document).ready(() => {

         let ajax = new AjaxTools({
             target: "#main-form",
             rules: {},
             reset: false,
             ajax: (form) => {
                 return {
                     method: 'POST',
                     enctype: 'multipart/form-data',
                     processData: false,
                     cache: false,
                     contentType: false,
                     url: `${BASE_URL}/back/group/${DATA_ID}`,
                     data: new FormData(form),
                     cbSuccess: (e) => {
                         console.log(e);
                     },
                     cbError: (e) => {
                         console.log(e);
                     }
                 }
             }
         }).init(); 
     });
 </script>