<?php

namespace App\Http\Controllers\Back;

use App\Helpers\MailHelper;
use App\Helpers\RateHelper;
use App\Libraries\NJYImage\ImageHelper;
use App\Models\ActivityLog;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends BackController
{
    protected $basePath = 'back.user';
    protected $model = 'App\Models\User';
    protected $title = 'Member Management';
    protected $title_update = 'Update Member';
    protected $title_create = 'Add Member';
    protected $title_show = 'Review Member';
    protected $title_update_password = 'Update Password';
    protected $rules_create = "";

    public function regional($region_id, Request $request)
    {
        parent::list($request);
    }

    public function sendPostRequest(Request $request)
    {
        $client = new Client();

        $response = $client->post('https://konnek.social/api/create-account', [
            'form_params' => [
                'username' => $request->post("username"),
                'password' => $request->post("password"),
                'email' => $request->post("email"),
                'confirm_password' => $request->post("password"),
                'server_key' => '4bf431d8b30268ded27eaf0c83d191fe',
                'first_name' => $request->post("name"),
                'last_name' => $request->post("name")
            ]
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if (isset($responseBody['access_token'])) {
            $token = $responseBody['access_token'];
     

        $joinGroupResponse = $client->post('https://konnek.social/api/join-group?access_token={$token}', [
            'form_params' => [
                'server_key' => '4bf431d8b30268ded27eaf0c83d191fe',
                'group_id' => 1
            ]
        ]);

        $joinGroupResponseBody = json_decode($joinGroupResponse->getBody(), true);

      } 

       return $token;

    }

    public function show(string $id, Request $request)
    {
        $data = app($this->model)->getRow($id);

        if (empty($data)) {
            abort(404);
        }

        $referrer = "N/A";

        if(!empty($data['referred_by'])){
            $referrer_model = User::find($data['referred_by']);
            $referrer = $referrer_model['name'] ?? "N/A";
        }

        if (empty($data['profile'])) {
            $data['profile'] = '/img/default_profile.png';
        } else {
            $data['profile'] = "{$data['profile']}";
        }

        $data['referrer'] = $referrer;
        $data['is_pending'] = $data['state'] == 'pending';

        return $this->render('show', [
            'title' => $this->title_show,
            'id' => $id,
            'logs' => ActivityLog::recent($id),
            'data' => $data,
            'theme' => 'bg-gray-100',
            'valid_ids' => app('App\Models\ValidIdentity')->getRowByUserId($id)
        ]);
    }

    protected function postRender(&$data)
    {
        parent::postRender($data);
        $data['municipal_id'] = $data['municipal_id'] ?? '';
        $data['status'] = $data['status'] ?? '';
        $data['role'] = $data['role'] ?? '';
        $data['analytics'] = $data['analytics'] ?? [
            "pending" => 0
        ];
    }

    public function filter(Request $request)
    {
        $title = $this->title;
        $request->validate([
            'municipal_id' => 'nullable|alpha_dash',
            'barangay_id' => 'nullable|alpha_dash',
            'role' => 'nullable|in:national,regional,municipal,member',
            'status' => 'nullable|in:pending,approved,restricted,banned'
        ]);

        $municipal_id = $request->get('municipal_id') ?? '';
        $barangay_id = $request->get('barangay_id') ?? '';
        $role = $request->get('role') ?? '';
        $status = $request->get('status') ?? '';
        $municipal = [];

        if (!empty($municipal_id)) {
            $municipal = app(Municipal::class)->getRow($municipal_id);
            if (empty($municipal)) abort(404);
        }

        return $this->render('index', [
            'municipal_id' => $municipal_id,
            'barangay_id' => $barangay_id,
            'municipal' => $municipal,
            'role' => $role,
            'status' => $status,
            'analytics' => [
                'pending' => app(User::class)->getPendingCount($municipal_id)
            ],
            'title' => $title
        ]);
    }

    public function updateState(Request $request)
    {
        $request->validate([
            "id" => "string|exists:users,id",
            "state" => "required|in:approve,decline,banned"
        ]);

        $user = User::find($request->post("id"));

        $user->update([
            'state' => $request->post('state')
        ]);

        return response()->json([
            "success" => false,
            "message" => "invalid action `{$request->post("action")}`"
        ]);
    }

    public function review(Request $request)
    {
        $request->validate([
            "id" => "string|exists:users,id",
            "remarks" => "string|nullable|max:1000",
            "action" => "required|in:approve,decline"
        ]);

        $user = User::find($request->post("id"));
        $user_info = UserInfo::where('user_id', $request->post("id"))->first();

        switch ($request->post("action")) {
            case "approve":
                $user->update([
                    'state' => 'approved'
                ]);
                $user_info->update([
                    'remarks' => $request->post("remarks"),
                    'approved_by' => Auth::id()
                ]);

                MailHelper::mailMembership($user, Auth::user());

                break;
            case "decline":
                $user->update([
                    'state' => 'declined'
                ]);
                $user_info->update([
                    'remarks' => $request->post("remarks")
                ]);
                break;
            default:
                return response()->json([
                    "success" => false,
                    "message" => "invalid action `{$request->post("action")}`"
                ]);
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'municipal_id' => "nullable|alpha_dash"
        ]);

        $municipal_id = $request->get('municipal_id');

        if (!empty($municipal_id)) {
            $data = app(Municipal::class)->getRow($municipal_id);

            if (empty($data)) abort(404);

            return $this->render('create', [
                'municipal_id' => $municipal_id,
                'data' => $data,
                'title' => $this->title_create
            ]);
        } else {
            return $this->render('create', [
                'title' => $this->title_create
            ]);
        }
    }

    public function store(Request $request)
    {

        $d = "{$request->post('year')}-{$request->post('month')}-{$request->post('day')}";

        if (!$request->has('birthday') && 
        $request->has('year') && 
        $request->has('month') &&
        $request->has('day')) {
            $request->merge([
                'birthday' =>  $d
            ]); 
        }else if($request->has('birthday') && empty($request->post('birthday'))){
            $request->merge([
                'birthday' =>  date("Y-m-d")    
            ]);
        }

        if(empty($request->post('civil_status'))){
            $request->merge([
                'civil_status' =>  "single"    
            ]);
        }


        $request->validate([
            "name" => "required|alpha_space|max:255",
            "email" => "required|email|max:255",
            "region_id" => "nullable|alpha_dash|max:255",
            "municipal_id" => "required|alpha_dash|max:255",
            "barangay_id" => "nullable|alpha_dash|max:255",
            "provincial_id" => "required|alpha_dash|max:255",
            "address" => "nullable|alpha_space|max:255",
            "birthday" => "nullable|date",
            "birthplace" => "nullable|alpha_space|max:255",
            "civil_status" => "nullable|in:single,married,divorced,widowed",
            "nationality" => "nullable|alpha_space|max:255",
            "voters_id" => "nullable|alpha_dash|max:255",
            "company_name" => "nullable|alpha_space|max:255",
            "company_position" => "nullable|alpha_space|max:255",
            "affiliations" => "nullable|alpha_space|max:255",
            "educational_attainment" => "nullable|alpha_dash|max:255",
            "special_skills" => "nullable|alpha_space|max:255",
            "remarks" => "nullable|alpha_space|max:255",
            "referred_by" => "nullable|alpha_dash|max:255",
            "contact_number" => "nullable|alpha_space|max:255",
            "profile_img" => "nullable|image|mimes:png,jpg,image/jpeg",
            "image_group.*.image" => "nullable|image|mimes:png,jpg,image/jpeg",
            "image_group.*.no" => "nullable|string|max:255",
            "image_group.*.type" => "nullable|string|max:255",
            "username" => "required|max:20|unique:users,username|alpha_num",
            "sub_group" => "nullable|alpha_dash",
            "precinct" => "nullable|alpha_dash|max:20",
            "endorsed_by" => "nullable|alpha_space|max:255",
            "auth_login" => "nullable|boolean"
        ]);

        try {
            //TODO: SECURITY CRUD
            //REGION ID AND MUNICIPAL ID SHOULD NOT BE CONFIGURED IN CLIENT SIDE UNLESS (Update: change id int to uuid)
            //Region can only control which municipality the person should go
            //municipality has no control at all
            //national has control on both.
            DB::beginTransaction();
         //   $profile_path = $request->file("profile_img")->store('public');
         //   ImageHelper::cropProfile($profile_path);

            $region = app(Province::class)->getRow($request->post("provincial_id"));
            $regional_id = $request->post("region_id") ?? $region->region_id ?? 0;


            $res = $this->model::create([
                "role" => "member",
                "name" => $request->post("name"),
                "email" => $request->post("email"),
                // "password" => $request->post("password") ?? Str::random(10),
                "password" => $request->post("password") ?? 'pilipinas',
                "regional_id" => $regional_id,
                "barangay_id" => $request->post("barangay_id"),
                "municipal_id" => $request->post("municipal_id"),
                //"profile" => "/storage/$profile_path",
                "username" => $request->post("username"),
                "state" => "approved"
            ]);


            if (empty($res['id'])) {
                throw new \Exception("no user id");
            }

            UserInfo::create([
                "user_id" => $res['id'],
                "address" => $request->post("address"),
                "birthday" => $request->post("birthday"),
                "birthplace" => $request->post("birthplace"),
                "civil_status" => $request->post("civil_status"),
                "nationality" => $request->post("nationality"),
                "contact_number" => $request->post("contact_number"),
                "voters_id" => $request->post("voters_id"),
                "company_name" => $request->post("company_name"),
                "company_position" => $request->post("company_position"),
                "affiliations" => $request->post("affiliations"),
                "educational_attainment" => $request->post("educational_attainment"),
                "special_skills" => $request->post("special_skills"),
                "remarks" => $request->post("remarks"),
                "referred_by" => $request->post("referred_by"),
                "sub_group" => $request->post("sub_group"),
                "encoded_by" => Auth::user()->id ?? null,
                "precinct" => $request->post("precinct"),
                "endorsed_by" => $request->post("endorsed_by")
            ]);

            //TODO: SECURITY - personal images should always be encrypted
            if (!empty($request->post('image_group')) && is_array($request->post('image_group'))) {
                for ($i = 0; $i < count($request->post('image_group')); $i++) {
                    if (empty($request->file("image_group.$i.image"))) continue;

                    $image_path = $request->file("image_group.$i.image")->store('private');

                    ValidIdentity::create([
                        "user_id" => $res['id'],
                        "no" => $request->input("image_group.$i.no"),
                        "type" => $request->input("image_group.$i.type"),
                        "image" => "/storage/$image_path",
                    ]);
                }
            }


            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "message" => $ex->getMessage(),
                "trace" => $ex->getTrace()
            ], 422);
        }

        $credentials = [
            "username" => $request->post('username'),
            "password" => $request->post('password')
        ];

        if($request->post("auto_login") && Auth::attempt($credentials)){
            $request->session()->regenerate();
        }

        $access_token = $this->sendPostRequest($request);
        
       // dd($apiResponse); 

        return response()->json([
            "success" => true,
            "access_token" => $access_token
        ]);
    }

    public function editPassword($user_id, Request $request)
    {
        $data = app($this->model)->getRow($user_id);

        if ($user_id != Auth::id()) {
            abort(403);
        }

        return $this->render('update_password', [
            'title' => $this->title_update_password,
            'id' => $user_id,
            'data' => $data
        ]);
    }

    protected function preUpdate(Request $request, &$row_update, string $id)
    {
        $request->validate([
            "profile_img" => "nullable|image|mimes:png,jpg,image/jpeg"
        ]);

        if ($request->has('username')) {
            $request->validate([
                "username" => "required|max:20|unique:users,username,{$id}"
            ]);
        }

        if (isset($row_update['password']) && $id != Auth::id()) {
            abort(403);
        } else if (isset($row_update['password']) && $id == Auth::id()) {
            if (!Hash::check($request->post('old_password'), Auth::user()->password)) {
                throw ValidationException::withMessages([
                    "old_password" => 'Invalid Credentials'
                ]);
            }
        }

        if (empty($request->has('password'))) {
            RateHelper::AccountLimit(
                "user:{$id}",
                days: config('constants.rate_limit.user')
            );
        }

      /*  if ($request->has('profile_img')) {
            $profile_path = $request->file("profile_img")->store('public');
            ImageHelper::cropProfile($profile_path);
            $row_update['profile'] = "/storage/$profile_path";
        }*/
    }

    public function verifyAll($id, Request $request)
    {
        $request->merge([
            "id" => $id
        ]);

        $request->validate([
            "ids" => "nullable|array",
            "ids.*" => "nullable|alpha_dash",
            "id" => "nullable|alpha_dash"
        ]);

        $encoder = Auth::user()->id;

        if ($id == 'multiple') { 
            app($this->model)->verifyAll($request->post('ids'), $encoder);
            return response()->json([
                "message" => "Success: All members are now verified.",
                "success" => true,
                "data" => $request->post('ids'),
                "id" => $id
            ]);
        } else {
            app($this->model)->verify($id, $encoder);
            return response()->json([
                "success" => true
            ]);
        }
    }
}
