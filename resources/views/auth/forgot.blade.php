<div class="w-full flex justify-center">
    <div class="card md:w-1/2 lg:w-1/3 w-full bg-base-100 shadow-lg  mx-5">
        <div class="card-body">
            <h2 class="font-bold text-2xl text-center mb-5">Forgot Password</h2>
            <form action="" id="forgot">
                <input type="text" name='username' class="input input-bordered w-full" placeholder="username" required>
                <br>
                <br>
                <button class="btn bnt-lg btn-success w-full" type="submit">Send Password Reset</button> 
                <div class="flex pt-3">
                    <a href="/auth/login" class="w-full text-center text-slate-700">back to login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    new AjaxTools({
        target: "#forgot",
        rules: {},
        message: {
            success: 'Password request sent to your mail!',
            fail: "Unable to reset password, please check your credentials"
        },
        ajax: () => {
            return {
                type: 'POST',
                url: `${BASE_URL}/auth/forgot`,
                data: $("#forgot").serialize(),
                cbSuccess: (e) => {

                },
                cbError: (e) => {

                }
            }
        }
    }).init();
</script>