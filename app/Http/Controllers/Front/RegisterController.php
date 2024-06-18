<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\BaseController;
use App\Models\Group;
use App\Models\Municipal;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory; 

class RegisterController extends FrontController
{
    protected $baseLayout = "include.layout";
    protected $basePath = 'front.registration';
    protected $title = "Member Registration";

    public function verify($municipal_id, Request $request)
    {

        try {
            $request->validate([
                "username" => "required|max:20|unique:users,username|alpha_num",
                "profile_img" => "nullable|image|mimes:png,jpg,image/jpeg"
            ]);

            return response()->json("true");
        } catch (ValidationException $ex) {
            return response()->json([
                $ex->getMessage()
            ]);
        }
    }

    public function show($municipal_id, Request $request)
    {
        $res = app(Municipal::class)->getRow($municipal_id);
        if (empty($res)) {
            abort(404);
        }

        $request->validate([
            'ref' => 'nullable|alpha_dash'
        ]);

        $data = [
            'title' => $this->title,
            'id' => $res['id'],
            'data' => $res
        ];

        if ($request->has('ref')) {
            $user = User::where('id', $request->get('ref'))->first();
            if (!empty($user)) {
                $data['referrer'] = $user;
            }

            $info = UserInfo::where('user_id', $request->get('ref'))->first();


            if (!empty($info)) {
                $group = Group::find($info['sub_group']);
                $data['sub_group'] = $group;
            }
        }

        return $this->render('show', $data);
    }

    public function store($municipal_id, Request $request)
    {
        $res = app(Municipal::class)->getRow($municipal_id);
        if (empty($res)) {
            abort(404);
        }

        //restrict users from using other municipals
        // $request->merge([
        //     'municipal_id' => $res['id'],
        //     'region_id' => $res['region_id']
        // ]);

        return app(UserController::class)->store($request);
    }


    public function downloadPasskey(Request $request)
    {  

         Validator::make($request->all(),[
            "username" => "required|string",
            "password" => "required|string"
         ]);

        $encoded = $this->generatePassImage($request->get("username") ?? "", $request->get("password") ?? "");
 
        return response()->stream(function () use ($encoded) {
            echo $encoded;
        }, 200, [
            'Content-Disposition' => 'attachment; filename=passkey.png',
            'Content-Type' => "image/png"
        ]);

        // return response($encoded)->header('Content-Type', "image/png");
    }

    public function generatePassImage($username, $password)
    {
        $manager = new ImageManager(Driver::class);
        // echo public_path("img/templates/bbm_default_id.jpg");
        // die();
        $base = $manager->read(public_path("img/templates/bbmp_default_id.jpg"));
        // echo $profile_img;
        // die();

        $image = $manager->create(640, 480);

        $image = $image->fill("#fff");

        $image->text(url('/'), $image->width() / 2,  $image->height() / 2 - 50, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#111');
            $font->size(30);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $image->text($username, $image->width() / 2,  $image->height() / 2, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#111');
            $font->size(30);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $image->text($password, $image->width() / 2,  $image->height() / 2 + 50, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#111');
            $font->size(30);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $encoded = $image->encodeByExtension('png');

        return $encoded;
    }
}
