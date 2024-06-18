<script>
    let SHOW_LOGIN = "{{$show_login_url}}";
</script>
<div class="w-full flex justify-center">
    <div class="card md:w-1/2 lg:w-1/3 w-full bg-base-100 shadow-lg mx-5">
        <div class="card-body">
            <h2 class="font-bold text-2xl text-center mb-5">Reset Password</h2>
            <form action="" id="reset">
                <input type="hidden" name="token" value="{{$token}}">
                <input type="hidden" name="username" value="{{$username}}">
                <div class=" mb-3">
                    <input type="password" id='password' name='password' class="input input-bordered w-full" placeholder="password" required>
                </div>
                <input type="password" name='password_confirmation' class="input input-bordered w-full" placeholder="confirm password" required>
                <br>
                <br>
                <button class="btn bnt-lg btn-success w-full" type="submit">Send Password Reset</button> 
                <div class="flex pt-3 ">
                    <a href="/auth/login" class="w-full text-center text-slate-700 fn-hidden-login" style="display:none">back to login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    new AjaxTools({
        target: "#reset",
        rules: {
            password: {
                minlength: 8
            },
            password_confirmation: {
                minlength: 8,
                equalTo: "#password"
            }
        },
        message: {
            success: 'Password has reset. You may now log-in',
            fail: "Unable to reset password, please check your credentials."
        },
        ajax: () => {
            return {
                type: 'POST',
                url: `${BASE_URL}/auth/reset`,
                data: $("#reset").serialize(),
                cbSuccess: (e) => {
                    if(SHOW_LOGIN == "1"){
                        $('.fn-hidden-login').css('display','block');
                    }
                },
                cbError: (e) => { 
                }
            }
        }
    }).init();
</script>