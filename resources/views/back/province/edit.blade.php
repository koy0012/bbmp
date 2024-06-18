 
 <script>
    let DATA_ID = '{{$id}}';
 </script>
<div class='w-3/4 mx-auto'>
    <h1 class='text-2xl mb-5'>{{$title}}</h1>

    <form class='fn-create-form' id='main-form'>
        <div class="flex justify-between">
            <div class="w-full pr-5">
                <div class='input-group'>
                    <label for="name">Region</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='region_id' type="text" required />
                    </div>
                </div>
            </div>
            <div class="w-full ">
                <div class='input-group'>
                    <label for="name">Municipal</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='municipal_id' type="text" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between" data-group='form-slider' data-tab='0'>
            <div class="w-full pr-5">
                <div class='input-group'>
                    <label for="name">Fullname</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='name' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Email</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='email' type="email" required />
                    </div>
                </div>

                <div class='input-group'>
                    <label for="name">position</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='position' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">address</label>
                    <div class='input-subgroup'>
                        <textarea name="address" id="" cols="30" rows="10" class="input input-bordered w-full"></textarea>
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">birthday</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='birthday' type="date" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">birthplace</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='birthplace' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Civil Status</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='civil_status' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Nationality</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' value="Filipino" name='nationality' type="text" readonly />
                    </div>
                </div>

                <div class='input-group'>
                    <label for="name">Contact Number</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='contact_number' type="text" required />
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class='input-group'>
                    <label for="name">Voters Id</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='voters_id' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Company Name</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='company_name' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Company Position</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='company_position' type="text" required />
                    </div>
                </div>

                <div class='input-group'>
                    <label for="name">affiliations</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='affiliations' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">educational attainment</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='educational_attainment' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">special skills</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='special_skills' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Remarks</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='remarks' type="text" required />
                    </div>
                </div>

                <div class='input-group'>
                    <label for="name">Referred By</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='referred_by' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Encoded By</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='encoded_by' type="text" required />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between w-full" data-group='form-slider' data-tab='1'>
            <div class="w-full pr-5">
                <div class='input-group'>
                    <div class="flex justify-center w-full">
                        <img class="h-[150px]" src="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" alt="">
                    </div>
                    <label for="name">Valid ID 1</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full' name='image_group[0][image]' type="file" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Number</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full' name='image_group[0][no]' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Type</label>
                    <div class='input-subgroup'>
                        <select class="input input-bordered" name="image_group[0][type]" id="" required>
                            <option value="">None</option>
                            @foreach(config('constants.valid_ids') as $row => $key)
                            <option value="{{$row}}">{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class='input-group'>
                    <div class="flex justify-center w-full">
                        <img class="h-[150px]" src="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" alt="">
                    </div>
                    <label for="name">Valid ID 1</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full' name='image_group[1][image]' type="file" />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Number</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full' name='image_group[1][no]' type="text" />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Type</label>
                    <div class='input-subgroup'>
                        <select class="input input-bordered" name="image_group[1][type]" id="">
                            <option value="">None</option>
                            @foreach(config('constants.valid_ids') as $row => $key)
                            <option value="{{$row}}">{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class='flex justify-end'>
            <button class='btn btn-primary mr-2 fn-prev-tab' type='button'>
                Previous
            </button>
            <button class='btn btn-primary  mr-2 fn-next-tab' type='button'>
                Next
            </button>
            <button class='btn btn-primary fn-create-submit' type='submit' disabled>
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
            ajax: (form) => {
                return {
                    method: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    url: `${BASE_URL}/back/user`,
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

        let index = 0;

        let form_slides = $(`[data-group='form-slider']`);

        console.log(form_slides.length);

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