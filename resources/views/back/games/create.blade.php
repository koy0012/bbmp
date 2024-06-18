<div class='mx-auto'>
    <h1 class='text-2xl mb-5'>{{$title}}</h1>

    <form class='fn-create-form' id='main-form'>

        <div class="flex justify-between flex-col" data-group='form-slider' data-tab='0'>
            <div class="flex items-center justify-between flex-col lg:flex-row">
                <div class="order-2 lg:order-1">
                    <p class="font-medium text-lg mb-3">Location of Registration</p>
                    @if(empty($data))
                    <div class="flex justify-between">
                        <div class="w-full pr-5">
                            <div class='input-group'>
                                <label for="name">Provincial *</label>
                                <div class='input-subgroup'>
                                    <select id="provincial-select" name="provincial_id" required></select>
                                </div>
                            </div>
                            <div class='input-group'>
                                <label for="name">Barangay *</label>
                                <div class='input-subgroup'>
                                    <select id="barangay-select" name="barangay_id" required> </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full ">
                            <div class='input-group'>
                                <label for="name">Municipal *</label>
                                <div class='input-subgroup'>
                                    <select id="municipal-select" name="municipal_id" required></select>
                                </div>
                            </div>
                        </div>

                    </div>
                    @else
                    <input type="hidden" name="region_id" value="{{$data['region_id']}}">
                    <input type="hidden" name="municipal_id" value="{{$data['id']}}">
                    <h1 class="text-2xl">{{$data['region']}},{{$data['name']}}</h1>
                    <div class='input-group'>
                        <label for="name">Barangay {{$data['barangay']}}</label>
                        <div class='input-subgroup'>
                            <select id="barangay-select" name="barangay_id" required> </select>
                        </div>
                    </div>
                    @endif
                    <p class="text-info">The registration location is unrelated to their current residence; it simply indicates the place of registration.</p>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="w-40 h-40">
                        <img class="object-cover rounded-lg w-full h-full" id="profile-img" alt="">
                    </div>
                </div>
            </div>
            <hr class="my-5">
            <p class="font-medium text-lg mb-3">Member Info</p>
            <div class="flex justify-between flex-col lg:flex-row">
                <div class="w-full pr-5">
                    <div class='input-group'>
                        <label for="name">Fullname *</label>
                        <div class='input-subgroup'>
                            <input  data-func='user-gen' data-target='#username' class='input input-bordered w-full' name='name' type="text" required />
                        </div>
                    </div>
                    <div class="input-cutter">
                        <div class='input-group'>
                            <label for="name">Email *</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' name='email' type="email" required />
                            </div>
                        </div>
                        <div class='input-group'>
                            <label for="name">Username *</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' data-func='user-gen' id="username" name='username' type="text" required />
                            </div>
                        </div>
                    </div>

                    <div class='input-group'>
                        <label for="name">Member Position</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='position' placeholder="e.g Deputy Director" type="text" />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Address</label>
                        <div class='input-subgroup'>
                            <textarea name="address" id="" cols="30" rows="10" class="input input-bordered w-full"></textarea>
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">birthday </label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='birthday' type="date" />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">birthplace</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='birthplace' type="text" />
                        </div>
                    </div>
                    <div class="input-cutter">
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
                            <label for="name">Nationality *</label>
                            <select name="nationality" id="" class='input input-bordered w-full capitalize'>
                                @foreach(config('constants.nationality') as $row)
                                <option value="{{$row}}">{{$row}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class='input-group'>
                        <label for="name">Contact Number</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='contact_number' type="text" />
                        </div>
                    </div>

                </div>
                <div class="w-full">
                    <div class='input-group'>
                        <label for="name">Profile Picture *</label>
                        <div class='input-subgroup'>
                            <input class='file-input input-bordered w-full fn-img-change' name='profile_img' type="file" data-output="#profile-img" data-href-id="#valid-id-1h" data-default="/img/default_profile.png" required />
                        </div>
                    </div>
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
                    <div class="input-cutter">
                        <div class='input-group'>
                            <label for="name">Company Name</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' name='company_name' type="text" />
                            </div>
                        </div>
                        <div class='input-group'>
                            <label for="name">Company Position</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' name='company_position' type="text" />
                            </div>
                        </div>
                    </div>

                    <div class='input-group'>
                        <label for="name">affiliations/religion/organization</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='affiliations' type="text" />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">educational attainment</label>
                        <div class='input-subgroup'>
                            <select name="educational_attainment" class="input input-bordered capitalize">
                                <option value=""></option>
                                @foreach(config('constants.attainments') as $row => $key)
                                <option value="{{$row}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">special skills</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='special_skills' type="text" />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Sub Group</label>
                        <div class='input-subgroup'>
                            <select id="group-select" name="sub_group"></select>
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
        <div class="flex justify-between w-full flex-col lg:flex-row" data-group='form-slider' data-tab='1'>
            <div class="w-full pr-5 mb-5">
                <div class='input-group'>
                    <div class="flex justify-center w-full">
                        <a id="valid-id-1h" href="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" data-lightbox="image-1" data-title="valid id 1">
                            <img id="valid-id-1" class="h-[150px]" src="" alt="">
                        </a>
                    </div>
                    <label for="name">Valid ID 1 *</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full fn-img-change' name='image_group[0][image]' type="file" data-output="#valid-id-1" , data-href-id="#valid-id-1h" , data-default="https://images.examples.com/wp-content/uploads/2019/10/Horizontal-ID-Cards.jpg" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Number *</label>
                    <div class='input-subgroup'>
                        <input class='file-input input-bordered w-full' name='image_group[0][no]' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">ID Type *</label>
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
            <div class="w-full mb-5">
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

        let ajax = new AjaxTools({
            target: "#main-form",
            ignore: ":hidden",
            message: {
                fail: "Form fields are invalid, kindly check & correct the required fields before proceeding, including the previous forms if you must.",
                success: "membership request sent"
            },
            rules: {
                password: {
                    minlength: 8
                },
                password_confirm: {
                    minlength: 8,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                username: {
                    required: true,
                    maxlength: 20,
                    remote: {
                        url: `${BASE_URL}/register/0000/validate`,
                        method: 'POST'
                    }
                }
            },
            reset: true,
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
                        $(".fn-img-change").trigger("change");
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
        }

        updateSlides();


        $('.fn-next-tab').click(() => {
            if (index == form_slides.length - 1 || !ajax.validate()) {
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