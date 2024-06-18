<div class='mx-auto'>
    <h1 class='text-2xl mb-5'>{{$title}}</h1>

    <form class='fn-create-form' id='main-form'>

        <div class="flex justify-between flex-col" data-group='form-slider' data-tab='0'>

            <p class="font-medium text-lg mb-3">Details</p>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class='input-group'>
                    <label for="name">Name</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='name' type="text" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Short Name</label>
                    <div class='input-subgroup'>
                        <input class='input input-bordered w-full' name='short_name' type="text" placeholder="Short names are used in IDs" required />
                    </div>
                </div>
                <div class='input-group'>
                    <label for="name">Description</label>
                    <div class='input-subgroup'>
                        <textarea name="description" id="" cols="30" rows="10" class="input input-bordered w-full h-44"></textarea>
                    </div>
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
            message: {
                success: "Group has been created successfully. It is now available under subgroup options when adding new members."
            },
            ajax: (form) => {
                return {
                    method: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    url: `${BASE_URL}/back/group`,
                    data: new FormData(form),
                    cbSuccess: (e) => {
                        $("#main-form").trigger('reset');
                    },
                    cbError: (e) => {
                        console.log(e);
                    }
                }
            }
        }).init();

    });
</script>