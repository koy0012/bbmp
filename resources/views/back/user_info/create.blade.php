<div class='mx-auto'>
    <h1 class='text-2xl mb-5'>{{$title}}</h1>

    <form class='fn-create-form' id='main-form'>

        <div class="flex justify-between flex-col" data-group='form-slider' data-tab='0'>
            <p class="font-medium text-lg mb-3">Location of Registration</p>
            <div class="flex justify-between">
                <div class="w-full pr-5">
                    <div class='input-group'>
                        <label for="name">Region</label>
                        <div class='input-subgroup'>
                            <select id="region-select" name="region_id"></select>
                        </div>
                    </div>
                </div>
                <div class="w-full ">
                    <div class='input-group'>
                        <label for="name">Municipal</label>
                        <div class='input-subgroup'>
                            <select id="municipal-select" name="municipal_id"></select>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-info">Location of registration is not attached to where they live, it only means where they were registered</p>
            <hr class="my-5">
            <p class="font-medium text-lg mb-3">Member Info</p>
            <div class="flex justify-between ">
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
                            <select name="civil_status" class="input input-bordered capitalize">
                                <option value=""></option>
                                @foreach(config('constants.civil_status') as $row)
                                <option value="{{$row}}">{{$row}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Nationality</label>
                        <select name="nationality" id="" class='input input-bordered w-full capitalize'>
                            @foreach(config('constants.nationality') as $row)
                            <option value="{{$row}}">{{$row}}</option>
                            @endforeach
                        </select>
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
                        <label for="name">Voters ID</label>
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
                            <input class='input input-bordered w-full' name='referred_by' type="text" required placeholder="Member No." />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Encoded By</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' value="{{$encoder['name']}}" name='encoded_by' type="text" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between w-full" data-group='form-slider' data-tab='1'>
            <div class="w-full pr-5">
                <div class='input-group'>
                    <div class="flex justify-center w-full">
                        <a id="valid-id-1h" href="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" data-lightbox="image-1" data-title="valid id 1">
                            <img id="valid-id-1" class="h-[150px]" src="" alt="">
                        </a>
                    </div>
                    <label for="name">Valid ID 1</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full fn-img-change' name='image_group[0][image]' type="file" data-output="#valid-id-1" , data-href-id="#valid-id-1h" , data-default="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" required />
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
                        <a id="valid-id-2h" href="" data-lightbox="image-1" data-title="valid id 2">
                            <img id="valid-id-2" class="h-[150px]" src="" alt="">
                        </a>
                    </div>
                    <label for="name">Valid ID 2</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full fn-img-change' data-output='#valid-id-2' data-default='https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg' data-href-id='#valid-id-2h' name='image_group[1][image]' type="file" />
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