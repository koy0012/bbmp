<?php
$qr_reference = "/qrcode?url=" . url('/') . "/register/{$user['municipal_id']}?ref={$user['id']}";
?>

<div class="max-w-2xl mx-auto grid grid-cols-1 gap-4 ">
    <div class="grid lg:grid-cols-2 grid-cols-1 gap-3">
        <div class="app-plate bg-slate-500 text-center flex flex-col ">
            <h1 class="invisible lg:visible">My ID</h1>
            <div class="text-sm text-gray-800 flex flex-col gap-3 items-center justify-center flex-grow">
                <a class="my-auto" href="/valid_id/{{$user['id']}}/id?v={{$user['updated_at']}}" target='_blank'>
                    <div class="lg:max-h-56 lg:overflow-hidden">
                        <img class="object-cover h-full w-full" src="/valid_id/{{$user['id']}}/id" alt="">
                    </div>
                </a>
            </div>
        </div>
        <div class="app-plate bg-slate-500 text-center flex flex-col ">
            <h1>Referral Registration</h1>
            <div class="text-sm text-gray-800 flex flex-col gap-3  flex-grow">
                <a href="{{$qr_reference}}" class="flex  justify-center">
                    <img src="{{$qr_reference}}" alt="">
                </a>
            </div>
        </div>
    </div> 
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <a href="/org/profile/{{$user['id']}}/edit" class="btn btn-success"><div>
            Edit Account
        </div></a>
        <a href="/org/info/{{$user['id']}}/edit"  class="btn btn-success">Edit Info</a>
    </div> 

    <div class="app-plate bg-slate-500">
        <div class="flex flex-row items-center gap-3 mb-5">
            <img class="h-10 w-10 rounded-full" src="/img/go8-logo.png" alt="">
            <div>
                <p>Deputy Director</p>
                <div class="flex items-center flex-row gap-1 text-xs text-slate-700 ">
                    <p class="">Feb. 6, 2024 4:38pm</p>
                    <svg title="Posted on national level" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="text-sm text-gray-800 flex flex-col gap-3">
            <h1>Hi New Member!</h1>
            <p>Welcome aboard! We're thrilled to have you join our community. As you explore our website, you might notice that we're currently in the process of some exciting updates and improvements. We're working hard behind the scenes to ensure everything is just right for you.</p>
            <p>While we're tidying up, feel free to navigate around and familiarize yourself with what we have to offer. Whether you're here to connect with like-minded individuals, discover new resources, or engage in discussions, we're here to make your experience enjoyable and enriching.</p>
            <p>Don't hesitate to reach out if you have any questions or suggestions. Your feedback is invaluable as we strive to create the best possible platform for our members.</p>
            <p>Once again, welcome to the community! We can't wait to embark on this journey together with you.</p>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        new AjaxTools({
            target: "#post-form",
            rules: {},
            message: {
                fail: "Invalid Credentials"
            },
            ajax: () => {
                return {
                    type: 'POST',
                    url: `${BASE_URL}/org/post`,
                    data: $("#login").serialize(),
                    cbSuccess: (e) => {
                        if (e.route == "member") {
                            location.href = `${BASE_URL}/home`;
                        } else {
                            location.href = `${BASE_URL}/back/dashboard`;
                        }

                    },
                    cbError: (e) => {
                        console.log('kicking');
                        console.log($("#login").serialize());
                        console.log(e);
                    }
                }
            }
        }).init();

        let post_photo_cache = new DataTransfer();
        let indexer = 0;

        function draftImage(src, id) {
            let draft = `<div class="min-w-40 min-h-40 relative" id='draft-img-${id}'>
                        <div class="my-post-remove-img">
                            <svg data-id='${id}' class="fn-rm-draft-photo w-6 h-6 text-stone-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <img class="w-40 h-40 object-cover opacity-55" src="${src}" alt="">
                    </div>`;

            return draft;
        }

        $(document).on('click', ".fn-post-images", () => {
            $("#post-draft-photos").trigger('click');
        });

        $(document).on('click', '.fn-rm-draft-photo[data-id]', (e) => {
            let id = $(e.currentTarget).attr('data-id');
            console.log(e);

            let bin = new DataTransfer();

            $.each(post_photo_cache.files, (i, e) => {
                if (e.id != id) {
                    bin.items.add(e);
                }
            });

            post_photo_cache = bin;
            console.log(`#draft-img-${id}`);
            $(`#draft-img-${id}`).remove();
        });

        $("#post-draft-photos").change(() => {
            $.each($("#post-draft-photos")[0].files, (i, e) => {
                e.id = indexer;
                post_photo_cache.items.add(e);
                $("#photos-preview").append(
                    draftImage(URL.createObjectURL(e), indexer)
                );
                indexer++;
            });

            console.log("================");
            console.log(post_photo_cache.files);
            console.log("================");
        });

    });
</script>