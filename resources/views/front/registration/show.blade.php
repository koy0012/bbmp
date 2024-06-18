<script>
    let DATA_ID = '{{$id}}';
</script>



<div class='mx-auto px-5'>
    <form class='fn-create-form' id='main-form'>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="flex justify-end flex-col">
                <h1 class="text-xl">Select Registry</h1>
                <div class="flex justify-between">
                    <div class="w-full pr-5">
                        <div class='input-group'>
                            <label for="name">Provincial *</label>
                            <div class='input-subgroup'>
                                <select id="provincial-select" name="provincial_id" required></select>
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

                @if(!empty($referrer['name']))
                <p class="text-slate-500">Referred by: <span class="text-stone-700">{{$referrer['name'] ?? 'No Referrer'}}</span></p>
                @endif
                @if(!empty($sub_group))
                <p class="text-slate-500">Sub-Group: <span class="text-stone-700 capitalize">{{$sub_group['name']}}</span></p>
                <input type="hidden" name="sub_group" value="{{$sub_group['id']}}">
                @endif

                <input type="hidden" name="referred_by" value="{{$referrer['id'] ?? ''}}">
                <input type="hidden" name="auto_login" value="true">

            </div>
            <div class="flex lg:justify-end justify-center">
                <div class="w-40 h-40">
                    <img class="object-cover rounded-lg w-full h-full" id="profile-img" alt="">
                </div>
            </div>
        </div>
        <div class="flex items-center py-5">
            <p class="font-medium text-lg">Registration Form</p>
            <hr class="my-5 grow ml-5">
        </div>

        <div class="flex justify-between flex-col" data-group='form-slider' data-tab='0'>

            <div class="flex justify-between flex-col lg:flex-row gap-4">
                <div class="w-full">
                    <div class='input-group'>
                        <label for="name">Fullname *</label>
                        <div class='input-subgroup'>
                            <input data-target='#username' id='fullname' class='input input-bordered w-full' name='name' type="text" required />
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Email *</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='email' type="email" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <div class='input-group'>
                            <label for="name">Username *</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' name='username' type="text" id="username" required />
                            </div>
                        </div>
                        <div>
                            <div class='input-group'>
                                <label for="name " class="invisible">_</label>
                                <button data-func='user-gen' data-ref='#fullname' data-target='#username' type='button' class="btn btn-success w-full">
                                    Generate Username
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <div class='input-group'>
                            <label for="name">Password *</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' value="" name="password" type="password" id="password" placeholder="Password" />
                            </div>
                        </div>
                        <div class='input-group'>
                            <label for="name">Confirm Password *</label>
                            <div class='input-subgroup'>
                                <input class='input input-bordered w-full' value="" name="password_confirm" type="password" placeholder="Re-type password" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="w-full">
                        <div class='input-group'>
                            <label for="name">Profile Picture *</label>
                            <div class='input-subgroup'>
                                <input class='file-input input-bordered w-full fn-img-change' name='profile_img' type="file" data-output="#profile-img" data-href-id="#valid-id-1h" data-default="/img/default_profile.png"  />
                            </div>
                        </div>
                    </div>
                    <div class='input-group'>
                        <label for="name">Contact Number *</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='contact_number' type="text" required />
                        </div>
                    </div>

                    <div class='input-group'>
                        <label for="name">Endorsed By *</label>
                        <div class='input-subgroup'>
                            <input class='input input-bordered w-full' name='endorsed_by' type="text" required />
                        </div>
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


<div id="privacy-policy" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-5xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Privacy Policy
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <h2>Privacy Policy</h2>
                <p>At {{env('APP_ORG')}}, we take your privacy seriously. We are committed to protecting the privacy of our users in accordance with applicable data protection laws, including Republic Act No. 10173 or the Data Privacy Act of 2012. This Privacy Policy outlines how we collect, use, disclose, and protect your personal information when you visit our website.</p>

                <h3>Collection of Personal Information</h3>
                <p>When you interact with our website, we may collect certain personal information from you, such as your name, company, email address, contact number, and address, as required by our forms. Additionally, we may collect other information, including:</p>
                <ul>
                    <li>Details about your computer and your visits to our website, such as your IP address, geographical location, browser type and version, operating system, referral source, length of visit, page views, and website navigation paths.</li>
                    <li>Information from your social media profiles, if you choose to link your account with our website.</li>
                    <li>Information you provide when subscribing to our email notifications/newsletters or using our services.</li>
                    <li>Content you post on our website, including your username, profile pictures, and the content of your posts.</li>
                    <li>Communication content and metadata associated with any communication you send to us through our website.</li>
                    <li>Any other personal or official information you choose to share with us.</li>
                </ul>
                <p>We only collect personal information that you voluntarily provide to us. If you choose not to provide certain information, it may limit your ability to access certain features of our website or receive our services.</p>

                <h3>Purpose of Collecting Your Personal Information</h3>
                <p>We use the personal information we collect for the following purposes:</p>
                <ul>
                    <li>To provide and personalize our website and services for you.</li>
                    <li>To communicate with you, respond to your inquiries, and provide customer support.</li>
                    <li>To send you marketing communications, with your consent, about our services or those of carefully-selected third parties.</li>
                    <li>To analyze user trends and improve our website and services.</li>
                    <li>To comply with legal obligations and protect our rights and interests.</li>
                </ul>

                <!-- Add more sections as needed -->

                <h3>Contact Us</h3>
                <p>If you have any questions, comments, or concerns about this Privacy Policy or our data practices, please contact us at <a href="mailto:{{env('APP_CONTACT_EMAIL')}}">{{env('APP_CONTACT_EMAIL')}}</a>.</p>

                <h3>Consent</h3>
                <p>By clicking accept, you agree to the terms outlined in our Privacy Policy:</p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id='privacy-policy-accept' type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(() => {
        new DateHelper({
            day: "#select-day",
            month: "#select-month",
            year: "#select-year"
        }).init();

        let privacy = document.getElementById('privacy-policy');

        const modal = new Modal(privacy, {
            'backdrop': 'static'
        });

        // modal.show();

        $("#privacy-policy-accept").click(() => {
            modal.hide();
        });

        let ajax = new AjaxTools({
            message: {
                fail: "Form fields are invalid, kindly check & correct the required fields before proceeding, including the previous forms if you must."
            },
            target: "#main-form",
            ignore: ":hidden",
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
                precinct: {
                    maxlength: 20
                },
                username: {
                    required: true,
                    maxlength: 20,
                    remote: {
                        url: `${BASE_URL}/register/${DATA_ID}/validate`,
                        method: 'POST'
                    }
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
                    url: `${BASE_URL}/register/${DATA_ID}`,
                    data: new FormData(form),
                    cbSuccess: (e) => {

                        let username = $("#username").val();
                        let password = $("#password").val();
                        var xt = e.access_token;
                        if(xt == undefined){
                         var t = 'none';   
                        }else{
                        localStorage.setItem("token", xt);
                        var t = localStorage.getItem("token");
                       }
                        $(form).trigger("reset");
                        $(".fn-img-change").trigger("change");
                        window.open(`/passkey?username=${username}&password=${password}`, '_blank');
                       

    setTimeout(() => {
    makeModal('ask-permission', `<b>Congratulations!</b><br>You're now a member of Bagong Bansang Maunlad Pilipinas. You may log in to see your ID.`, () => {
        var redirect = 'https://konnek.social/api/set-browser-cookie?access_token=' + t;

        // Create a form element
        var form = document.createElement('form');
        form.setAttribute('id', 'dynForm');
        form.setAttribute('action', redirect);
        form.setAttribute('method', 'post');
        var hiddenField = document.createElement('input');
        hiddenField.setAttribute('type', 'hidden');
        hiddenField.setAttribute('name', 'server_key');
        hiddenField.setAttribute('value', '4bf431d8b30268ded27eaf0c83d191fe');
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        document.getElementById('dynForm').submit();
    });
}, 500);


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

            if (form_slides.length == 1) {
                $(".fn-next-tab").hide();
                $(".fn-prev-tab").hide();
            }

            onFormSlideUpdate(index);
        }

        updateSlides();

        $('.fn-next-tab').click(() => {
            console.log(ajax.validate());
            if (!ajax.validate()) return;

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