 
 <script>
     let DATA_ID = '{{$id}}';
 </script>
 <div class='w-3/4 mx-auto'>
     <h1 class='text-2xl mb-5'>{{$title}}</h1>

     <form class='fn-create-form' id='main-form'>
         <input type="hidden" name="_method" value="PUT">
         <div class="grid grid-col-1 lg:grid-col-2">
             <div class='input-group'>
                 <label for="name">Old Password</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' name='old_password' value="" type="password" required />
                 </div>
             </div>
             <div class='input-group'>
                 <label for="name">New Password</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' id="password" name='password' value="" type="password" required />
                 </div>
             </div>
             <div class='input-group'>
                 <label for="name">Confirm Password</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' name='confirm_password' value="" type="password" required />
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
             rules: {
                 password: {
                     minlength: 8
                 },
                 confirm_password: {
                     minlength: 8,
                     equalTo: "#password"
                 }
             },
             reset: false,
             ajax: (form) => {
                 return {
                     method: 'POST',
                     enctype: 'multipart/form-data',
                     processData: false,
                     cache: false,
                     contentType: false,
                     url: `${BASE_URL}/org/profile/${DATA_ID}`,
                     data: new FormData(form),
                     cbSuccess: (e) => {
                         $(form).trigger('reset');
                     },
                     cbError: (e) => {
                         console.log(e);
                     }
                 }
             }
         }).init();

     });
 </script>