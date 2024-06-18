 
 <script>
     let DATA_ID = '{{$id}}';
 </script>

 <div class='w-3/4 mx-auto'>

     <div>
         <h1 class='text-2xl'>{{$title}}</h1>
         <h1 class='text-xl mb-5 text-slate-500'>{{$data['name']}}</h1>
     </div>

     <form action="main-form" id="main-form">
         <input type="hidden" name="_method" value="PUT">
         <div class="flex items-center">
             <div class="w-1/2">
                 <div class="flex justify-center w-full">
                     <a id="valid-id-1h" href="" data-lightbox="image-1" data-title="valid id 1">
                         <img id="valid-id-1" class="h-[150px]" src="" alt="">
                     </a>
                 </div>
             </div>
             <div class="w-1/2">
                 <div class='input-group'> 
                     <label for="name">Valid ID 1</label>
                     <div class='input-subgroup'>
                         <input class='file-input input-bordered w-full fn-img-change' name='image' type="file" data-output="#valid-id-1" , data-href-id="#valid-id-1h" , data-default="{{$data['image']}}"/>
                     </div>
                 </div>
                 <div class='input-group'>
                     <label for="name">ID Number</label>
                     <div class='input-subgroup'>
                         <input class='file-input input-bordered w-full' value="{{$data['no']}}" name='no' type="text" required />
                     </div>
                 </div>
                 <div class='input-group'>
                     <label for="name">ID Type</label>
                     <div class='input-subgroup'>
                         <select class="input input-bordered" name="type" id="" required>
                             <option value="">None</option>
                             @foreach(config('constants.valid_ids') as $row => $key)
                             <?php
                                $is_selected = $row == $data['type'] ? "selected" : "";
                                ?>
                             <option value="{{$row}}" {{$is_selected}}>{{$key}}</option>
                             @endforeach
                         </select>
                     </div>
                 </div>
             </div>
         </div>

         <div class="flex justify-end">
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
                     url: `${BASE_URL}/back/valid_id/${DATA_ID}`,
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