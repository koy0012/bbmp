<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Wrapper\WRegionController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\Back\AccountController as BackAccountController;
use App\Http\Controllers\Back\UserInfoController;
use App\Http\Controllers\Back\ValidIdentityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;

use App\Http\Controllers\Front\RegisterController;

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Back\ActivityLogController;
use App\Http\Controllers\Back\GameController;
use App\Http\Controllers\Back\GroupController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\ProfileAccountController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\ProfileInfoController;
use App\Http\Controllers\Wrapper\WActivityLogController;
use App\Http\Controllers\Wrapper\WBarangayController;
use App\Http\Controllers\Wrapper\WMunicipalController;
use App\Http\Controllers\Wrapper\WProvinceController;
use App\Http\Controllers\Wrapper\WUserController;
use App\Http\Controllers\Wrapper\WUserInfoController;
use App\Http\Middleware\SanctumValidator;
use App\Models\AcitivityLog;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['throttle:auth'])->group(function () {
    Route::post('api/user/login', [ApiUserController::class, 'login'])->middleware([
        'throttle:auth'
    ]);
    Route::post('api/user/request_reset', [AuthController::class, 'requestReset']);
});

Route::middleware(SanctumValidator::class)->group(function () {
    Route::get('api/account/verify', [AccountController::class, 'verify']);
    Route::resource('api/account', AccountController::class)->except([
        'index'
    ]);

    Route::post('api/user/logout', [ApiUserController::class, 'logout']);
});


Route::post('register/{municipal}/validate', [RegisterController::class, 'verify']);
Route::get('register/{municipal}', [RegisterController::class, 'show']);
Route::post('register/{municipal}', [RegisterController::class, 'store']);

Route::get('privacy', [FrontController::class, 'privacy']);
Route::get('auth/verify/{user_id}', [AuthController::class, 'verify']);
Route::get('auth/login', [AuthController::class, 'login'])
    ->middleware([
        'member_guest'
    ])->name('login');
Route::get('auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/forgot', [AuthController::class, 'forgotPassword']);
Route::post('auth/forgot', [AuthController::class, 'requestReset']);
Route::post('auth/reset', [AuthController::class, 'resetPassword']);
Route::get('auth/reset/{token}', [AuthController::class, 'resetForm'])
    ->name('password.reset');

Route::middleware(['throttle:auth'])->post('auth/login', [AuthController::class, 'authenticate']);
Route::get('storage/{dir}/{path}', [StorageController::class, 'storage']);

Route::middleware(['throttle:limited'])->group(function () {
    Route::get('valid_id/{token}/id', [ValidIdentityController::class, 'showID']);
    //deprecated
    Route::get('back/valid_id/{token}/id', [ValidIdentityController::class, 'showID']);
});

Route::get('group/list', [GroupController::class, 'list']);
Route::get('barangay/list', [WBarangayController::class, 'publicList']);
Route::get('provincial/list', [WProvinceController::class, 'publicList']);
Route::get('municipal/list', [WMunicipalController::class, 'publicList']);
Route::get('regional/list', [WRegionController::class, 'publicList']);
Route::get('passkey', [RegisterController::class, 'downloadPasskey']);

Route::get('qrcode', function (Request $request) {
    $request->validate([
        "url" => "required|string"
    ]); 

    $url = $request->get("url"); 
    $base64 = (new QRCode())->render($url); 
    $replace = str_replace("data:image/svg+xml;base64,","",$base64);
    
    $imageData = base64_decode($replace); 
    return response($imageData)->withHeaders([ 
        'Content-Type' => 'image/svg+xml' 
    ]);;
    
});

Route::middleware([
    'auth'
])->group(function () {
    Route::get('home', [HomeController::class, 'index']);
    Route::post('ping', [HomeController::class, 'ping']);
    Route::get('org/profile/password/{user_id}/edit', [ProfileController::class, 'editPassword']);
    Route::resource('org/personal', ProfileAccountController::class);
    Route::resource('org/profile', ProfileController::class)->except([
        'create', 'store', 'index'
    ]);

    Route::resource('org/info', ProfileInfoController::class)->except([
        'create', 'store'
    ]);
    Route::get('org/activity/{user_id}', [WActivityLogController::class, 'show']);
    // Route::resource('profile', WUserController::class);
});



/*
    TOD: SECURE THIS WITH SPATIE USERS CAN STILL ACCESSS LIST
*/
Route::middleware([
    'auth',
    'role:barangay|municipal|provincial|regional|national'
])->group(function () {
    Route::resource('back/dashboard', DashboardController::class);

    Route::get('back/user/list', [WUserController::class, 'list'])->middleware(
        'role_or_permission:national|municipal|regional'
    );

    Route::group(['middleware' => ['can:regional.*']], function () {
        Route::get('back/group/list', [GroupController::class, 'list']);
        Route::resource('back/group', GroupController::class);
    });

    Route::group(['middleware' => ['can:municipals.members']], function () {
        Route::get('back/user/filter', [WUserController::class, 'filter']);
        Route::post('back/user/review', [WUserController::class, 'review']);
        Route::post('back/user/state', [WUserController::class, 'updateState']);
        Route::post('back/user/verifyAll/{id}', [WUserController::class, 'verifyAll']);
    });


    Route::get('back/user/password/{user_id}/edit', [WUserController::class, 'editPassword']);
    Route::resource('back/user', WUserController::class);

    Route::get('back/activity/list', [WActivityLogController::class, 'list']);
    Route::resource('back/activity', WActivityLogController::class)->only(['show']);

    Route::resource('back/user_info', WUserInfoController::class)->except([
        'create', 'store'
    ]);

    Route::resource('back/my-account', BackAccountController::class);
    Route::get('back/games/getActive', [GameController::class, 'getActiveUsers']);
    Route::resource('back/games', GameController::class);

    Route::get('back/valid_id/list', [ValidIdentityController::class, 'list']);
    Route::resource('back/valid_id', ValidIdentityController::class)->except([
        'create', 'store'
    ]);

    //PROVINCE START
    Route::get('back/province/manage/{municipal_id}', [WProvinceController::class, 'manage'])->middleware([
        'role_or_permission:national|regional'
    ]);
    Route::get('back/province/list', [WProvinceController::class, 'list']);
    Route::resource('back/province', WProvinceController::class);
    //PROVINCE END

    //REGION START
    Route::get('back/region/manage/{municipal_id}', [WRegionController::class, 'manage'])->middleware([
        'role_or_permission:national|regional'
    ]);
    Route::get('back/region/list', [WRegionController::class, 'list']);
    Route::resource('back/region', WRegionController::class);
    //REGION END

    //MUNICIPAL START
    Route::get('back/municipal/manage/{municipal_id}', [WMunicipalController::class, 'manage']);
    Route::get('back/municipal/list', [WMunicipalController::class, 'list']);
    Route::get('back/municipal/{province_id}/province', [WMunicipalController::class, 'province']);
    Route::resource('back/municipal', WMunicipalController::class)->middleware([
        'role_or_permission:national|regional'
    ]);
    // MUNICIPAL END

    //MUNICIPAL START
    Route::get('back/barangay/manage/{municipal_id}', [WBarangayController::class, 'manage']);
    Route::get('back/barangay/list', [WBarangayController::class, 'list']);
    Route::resource('back/barangay', WBarangayController::class)->middleware([
        'role_or_permission:national|regional'
    ]);
    // MUNICIPAL END

    Route::resource('back/review', WMunicipalController::class)->except([
        'create', 'store'
    ]);
});
