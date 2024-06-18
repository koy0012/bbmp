 
 <script>
     let DATA_ID = '{{$id}}';
 </script>
 <div class='w-3/4 mx-auto'>
     <div class="pb-10 flex flex-col lg:flex-row lg:justify-between lg:items-end">
         <div>
             <h1 class='text-2xl'>{{$title}}</h1>
             <p class="text-stone-700">{{$data['username']}}</p>
         </div>
         <div>
             <div class="w-40 h-40">
                 <img class="object-cover rounded-lg w-full h-full" id="profile-img" alt="">
             </div>
         </div>
     </div>



     <form class='fn-create-form' id='main-form'>
         <input type="hidden" name="_method" value="PUT">
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
             <div class='input-group'>
                 <label for="name">Full Name</label>
                 <div class='input-subgroup'>
                     <input class='input input-bordered w-full' name='name' value="{{$data['name']}}" type="text" required />
                 </div>
             </div>
             <div class='input-group'>
                 <label for="name">Profile Picture</label>
                 <div class='input-subgroup'>
                     <input class='file-input input-bordered w-full fn-img-change' name='profile_img' type="file" data-output="#profile-img" data-default="{{$data['profile']}}" />
                 </div>
             </div>

             @hasrole('national')
             <div class='input-group'>
                 <label for="name">Role</label>
                 <div class='input-subgroup'>
                     <select name="role" id="" class="input input-bordered w-full capitalize">
                         @foreach(config('constants.roles') as $row)
                         @if($row == $data['role'])
                         <option value="{{$row}}" selected>{{$row}}</option>
                         @else
                         <option value="{{$row}}">{{$row}}</option>
                         @endif
                         @endforeach
                     </select>
                 </div>
             </div>
             @endhasrole
         </div>

         @hasanyrole('municipal|national')
         <hr class="my-3">
         <p class="font-medium text-lg ">Localization</p>
         <p class="text-info">Location where the member is currently registered at.</p>
         <div class="flex flex-col lg:flex-row gap-3 justify-between">
             <div class="w-full">
                 <div class='input-group'>
                     <label for="name">Region</label>
                     <div class='input-subgroup'>
                         <select id="region-select" name="regional_id">
                             <option value="{{$data['regional_id']}}">{{$data['region']}}</option>
                         </select>
                     </div>
                 </div>


             </div>
             <div class="w-full">
                 <div class='input-group'>
                     <label for="name">Municipal</label>
                     <div class='input-subgroup'>
                         <select id="municipal-select" name="municipal_id">
                             <option value="{{$data['municipal_id']}}">{{$data['municipal']}}</option>
                         </select>
                     </div>
                 </div>
                 <div class='input-group'>
                     <label for="name">Barangay</label>
                     <div class='input-subgroup'>
                         <select id="barangay-select" name="barangay_id">
                             <option value="{{$data['barangay_id']}}">{{$data['barangay']}}</option>
                         </select>
                     </div>
                 </div>
             </div>
         </div>
         @else
         <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" >
             <span class="font-medium">NOTICE:</span> Before you confirm, you may only update your account once every thirty {{config('constants.rate_limit.user')}} day(s).
         </div>
         @endhasanyrole



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
             preRequest: () => {
                 return confirm("Are you sure you want to update?");
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

                     },
                     cbError: (e) => {

                     }
                 }
             }
         }).init();

     });
 </script>