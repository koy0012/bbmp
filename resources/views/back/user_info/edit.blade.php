 <script>
     let DATA_ID = '{{$id}}';
 </script>
 <div class='mx-auto'>
     
     <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end mb-5">
         <div class="order-2 lg:order-1">
             <h1 class='text-2xl'>{{$data['name']}}</h1>
             <h1 class='text-lg text-slate-700'>{{$title}}</h1>
             
         </div>
         <div class="order-1 lg:order-2">
             <div class="w-40 h-40">
                 <img class="object-cover rounded-lg w-full h-full" src="{{$data['profile']}}" alt="">
             </div>
         </div>
     </div>


     <form class='fn-create-form' id='main-form'>

         <div class="flex justify-between flex-col" data-group='form-slider' data-tab='0'>
             <input type="hidden" name="_method" value="PUT">
             <p class="font-medium text-lg mb-3">Member Info</p>
             <div class="flex justify-center lg:justify-between flex-col lg:flex-row">
                 <div class="w-full lg:pr-5">
                     @hasanyrole('national')
                     <div class='input-group'>
                         <label for="name">Member Position</label>
                         <div class='input-subgroup'>
                             <textarea data-limit-rows=true class='input input-bordered w-full' name="position" id="" cols="50" rows="2">{{$data['position']}}</textarea>
                         </div>
                     </div>
                     @endhasanyrole
                     <div class='input-group'>
                         <label for="name">address</label>
                         <div class='input-subgroup'>
                             <textarea name="address" id="" cols="30" rows="10" class="input input-bordered w-full">{{$data['address']}}</textarea>
                         </div>
                     </div>
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                         <div class='input-group'>
                             <label for="name">birthday </label>
                             <div class='input-subgroup'>
                                 <input class='input input-bordered w-full' name='birthday' value="{{date('Y-m-d',strtotime($data['birthday']))}}" type="date" required />
                             </div>
                         </div>
                         <div class='input-group'>
                             <label for="name">birthplace</label>
                             <div class='input-subgroup'>
                                 <input class='input input-bordered w-full' value="{{$data['birthplace']}}" name='birthplace' type="text" required />
                             </div>
                         </div>
                     </div>
                     <div class="input-cutter">
                         <div class='input-group'>
                             <label for="name">Civil Status</label>
                             <div class='input-subgroup'>
                                 <select name="civil_status" class="input input-bordered capitalize" required>
                                     <option value=""></option>
                                     @foreach(config('constants.civil_status') as $row)
                                     @if($data['civil_status'] == $row)
                                     <option value="{{$row}}" selected>{{$row}}</option>
                                     @else
                                     <option value="{{$row}}">{{$row}}</option>
                                     @endif
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                         <div class='input-group'>
                             <label for="name">Nationality</label>
                             <select name="nationality" id="" class='input input-bordered w-full capitalize'>
                                 @foreach(config('constants.nationality') as $row)
                                 @if($data['nationality'] == $row)
                                 <option value="{{$row}}" selected>{{$row}}</option>
                                 @else
                                 <option value="{{$row}}">{{$row}}</option>
                                 @endif
                                 @endforeach
                             </select>
                         </div>
                     </div>

                     <div class='input-group'>
                         <label for="name">Contact Number</label>
                         <div class='input-subgroup'>
                             <input class='input input-bordered w-full' value="{{$data['contact_number']}}" name='contact_number' type="text" required />
                         </div>
                     </div>

                     <div class='input-group'>
                         <label for="name">Sub Group</label>
                         <div class='input-subgroup'>
                             <select id="group-select" name="sub_group">
                                 <option value="{{$data['sub_group']}}">{{$data['sub_group_name']}}</option>
                             </select>
                         </div>
                     </div>
                 </div>
                 <div class="w-full">
                     <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                         <div class='input-group lg:col-span-2'>
                             <label for="name">Voters ID</label>
                             <div class='input-subgroup'>
                                 <input class='input input-bordered w-full' name='voters_id' type="text" />
                             </div>
                         </div>
                         <div class='input-group'>
                             <label for="name">Precinct</label>
                             <div class='input-subgroup'>
                                 <input class='input input-bordered w-full' name='precinct' type="text" />
                             </div>
                         </div>
                     </div>
                     <div class='input-group'>
                         <label for="name">Company Name</label>
                         <div class='input-subgroup'>
                             <input class='input input-bordered w-full' value="{{$data['company_name']}}" name='company_name' type="text" />
                         </div>
                     </div>
                     <div class='input-group'>
                         <label for="name">Company Position</label>
                         <div class='input-subgroup'>
                             <input class='input input-bordered w-full' value="{{$data['company_position']}}" name='company_position' type="text" />
                         </div>
                     </div>

                     <div class='input-group'>
                         <label for="name">affiliations</label>
                         <div class='input-subgroup'>
                             <input class='input input-bordered w-full' value="{{$data['affiliations']}}" name='affiliations' type="text" />
                         </div>
                     </div>
                     <div class='input-group'>
                         <label for="name">educational attainment</label>
                         <div class='input-subgroup'>
                             <select name="educational_attainment" class="input input-bordered capitalize" required>
                                 <option value=""></option>
                                 @foreach(config('constants.attainments') as $row => $key)
                                 <option value="{{$row}}" {{$data["educational_attainment"] == $row ? "selected" : ""}}>{{$key}}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class='input-group'>
                         <label for="name">special skills</label>
                         <div class='input-subgroup'>
                             <input class='input input-bordered w-full' value="{{$data['special_skills']}}" name='special_skills' type="text" />
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         @hasanyrole('municipal|android')
         @else
         <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300">
             <span class="font-medium">NOTICE:</span> Before you confirm, you may only update your account once every thirty {{config('constants.rate_limit.user_info')}} day(s).
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

         $(document).on('change', '.fn-img-change', (event) => {
             let output_id = event.target.getAttribute('data-output');
             let default_img = event.target.getAttribute('data-default');
             let href_id = event.target.getAttribute('data-href-id');

             var output = $(output_id);

             if (event.target?.files[0] != null) {
                 output.attr('src', URL.createObjectURL(event.target.files[0]));
                 $(href_id).attr('href', URL.createObjectURL(event.target.files[0]));
             } else {
                 output.attr('src', default_img);
                 $(href_id).attr('href', default_img);
             }


             output.onload = function() {
                 URL.revokeObjectURL(output.src) // free memory
             }
         });

         $('.fn-img-change').trigger('change');


         let ajax = new AjaxTools({
             target: "#main-form",
             rules: {},
             message: {
                 success: "Info Updated"
             },
             ajax: (form) => {
                 return {
                     method: 'POST',
                     enctype: 'multipart/form-data',
                     processData: false,
                     cache: false,
                     contentType: false,
                     url: `${BASE_URL}/org/info/${DATA_ID}`,
                     data: new FormData(form),
                     cbSuccess: (e) => {

                     },
                     cbError: (e) => {

                     }
                 }
             }
         }).init();

         let index = 0;

         let form_slides = $(`[data-group='form-slider']`);

         function onFormSlideUpdate(index) {
             if (index == form_slides.length - 1) {
                 $('.fn-next-tab').attr('disabled', '');
                 $('.fn-create-submit').removeAttr('disabled');
             } else {
                 $('.fn-create-submit').attr('disabled', '');
                 $('.fn-next-tab').removeAttr('disabled');
             }

             if (index == 0) {
                 $('.fn-prev-tab').attr('disabled', '');
             } else {
                 $('.fn-prev-tab').removeAttr('disabled');
             }
         }

         function updateSlides() {
             form_slides.each((i, e) => {
                 let tab = $(e).attr('data-tab');
                 if (tab != index) {
                     $(e).hide();
                 } else {
                     $(e).show();
                 }
             });
             onFormSlideUpdate(index);
             ajax.validate();
         }

         updateSlides();


         $('.fn-next-tab').click(() => {
             if (index == form_slides.length - 1) {
                 return;
             }
             index++;
             updateSlides();
         });

         $('.fn-prev-tab').click(() => {
             if (index == 0) {
                 return;
             }
             index--;
             updateSlides();
         });
     });
 </script>