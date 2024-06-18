<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- flowbite -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>


  @vite([
  'resources/css/app.css',
  'resources/js/app.js'
  ])

  <title>{{$title}}</title>
  <link rel="icon" href="{{env('APP_LOGO')}}">
  <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- lightbox2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    let BASE_URL = '{{$baseUrl}}';
    let BUGSNAG_API = "{{env('BUGSNAG_API_KEY')}}";
  </script>
  <script src="{{ asset('/js/crud_module.js') }}"></script>
  <script src="{{ asset('/js/ajax_tools.js') }}"></script>
  <script src="{{ asset('/js/image_helper.js') }}"></script>
  <script src="{{ asset('/js/date_helper.js') }}"></script>
  <link href="{{ asset('/css/default.css') }}" rel='stylesheet'>
  <script src="{{ asset('/js/make_modal.js') }}"></script>

  <script type="module">
    import BugsnagPerformance from '//d2wy8f7a9ursnm.cloudfront.net/v1/bugsnag-performance.min.js'
    BugsnagPerformance.start({
      apiKey: BUGSNAG_API
    });
  </script>

  </link>

  <style>
    .login-theme {
      background-image: url("{{env('APP_BG_LOGIN')}}");
      background-size: cover;
      background-position-y: bottom;
    }
  </style>

  <script>
    def_cm_config = {
      'crud': {
        'deleteAll': (module) => `${BASE_URL}/back/${module}/multiple`,
        'delete': (module, value) => `${BASE_URL}/back/${module}/${value}`,
        'getList': (module) => `${BASE_URL}/back/${module}/list`
      }
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-EHSHTHWVYG"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-EHSHTHWVYG');
  </script>
</head>

<body data-theme='lofi' class=" min-h-screen {{$theme}}">
  <div class="flex flex-col min-h-screen">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 ">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="{{env('APP_LOGO')}}" class="h-8 " alt="{{env('APP_NAME')}}" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white ">{{env('APP_NAME')}}</span>
        </a>
        <!-- <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button> -->
        <!-- <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
            <li>
              <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Home</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
            </li>
          </ul>
        </div> -->
      </div>
    </nav>
    <div class="container mx-auto grow py-10">
      @include($fullPath)
    </div>
    @foreach($addons as $addon)
    @include($addon)
    @endforeach

    <footer class="footer footer-center p-4 bg-stone-800 flex-none text-white">
      <aside>
        <p>Copyright © 2024 - All right reserved by {{env('APP_COMPANY')}}</p>
      </aside>
    </footer>
  </div>
</body>

</html>