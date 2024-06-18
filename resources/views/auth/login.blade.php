<div class="w-full flex justify-center">
    <div class="card md:w-1/2 lg:w-1/3 w-full bg-base-100 shadow-lg  mx-5">
        <div class="card-body">
            <h2 class="font-bold text-2xl text-center mb-5">Login</h2>
            <form action="" id="login">
                <input type="text" name='username' class="input input-bordered w-full" placeholder="username" required>
                <input type="password" name='password' class="input input-bordered w-full mt-3" placeholder="password" required>
                <!-- <a href="">Forgot Password</a> -->
                <br>
                <br>
                <button class="btn bnt-lg btn-success w-full" type="submit">Confirm</button>
                <div class="flex pt-3">
                    <a href="/auth/forgot" class="w-full text-center text-slate-700">forgot pasword</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    new AjaxTools({
        target: "#login",
        rules: {},
        message: {
            fail: "Invalid Credentials"
        },
        ajax: () => {
            return {
                type: 'POST',
                url: `${BASE_URL}/auth/login`,
                data: $("#login").serialize(),
                cbSuccess: (e) => {
                    if (e.route == "member") {
              //          console.log(e);
                     
var redirect = 'https://konnek.social/api/set-browser-cookie?access_token=' + e.token;
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
                    
//   location.href = `${BASE_URL}/home`;
                    }else {
                        location.href = `${BASE_URL}/back/dashboard`;
                    }

                },
                cbError: (e) => { 
                    //do nothing
                }
            }
        }
    }).init();
</script>