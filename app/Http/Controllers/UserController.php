<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $candidatos;
    protected $users;
    protected $roles;
    protected $redis;

    public function __construct()
    {
        $this->candidatos = Cache::get('Candidatos');
        $this->users = Cache::get('Users');
        $this->roles = Cache::get('Roles');
        $this->redis = Redis::connection();
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $validator  = ValidatorReponse($request->all());

        if ($validator['status'] === 'error') {
            return response()->json(ResponseJson([], false, $validator['message']), Http(401));
        }
        try {
            if (!Auth::attempt($credentials)) {
                return response()->json(ResponseJson([], false, "Password incorrect for: $request->username"), Http(401));
            }
        } catch (\Exception $e) {
            return response()->json(ResponseJson([], false, 'Could not create token'), Http(500));
        }
        return response()->json(ResponseJson(['token' => JWTAuth::attempt($credentials), 'min_to_expired' => 1440], true, ''), Http(200));
    }

    public function RegisterLead(Request $request)
    {
        $uValidate = ValidateToken('r');

        if ($uValidate['status'] === false) {
            return response()->json(ResponseJson('', false, $uValidate['message']), Http(401));
        }

        $validator  = ValidatorReponse($request->all(), 'r');

        if ($validator['status'] === 'error') {
            return response()->json(ResponseJson([], false, $validator['message']), Http(401));
        }

        try {
            $new = new Candidato();
            $new->name = $request->name;
            $new->source = $request->source;
            $new->owner = $uValidate['user']->id;
            $new->created_by = $uValidate['user']->id;
            $new->save();

            if(Cache::forget('Candidatos')){
                Cache::remember('Candidatos', 84600, function () {
                    return Candidato::get();
                });
            }
            
        } catch (\Exception $e) {
            return response()->json(ResponseJson([], false, $e->getMessage()), Http(500));
        }

        return response()->json(ResponseJson($new, true, []), Http(201));
    }

    public function GetLeadAll(Request $request)
    {
        $uValidate = ValidateToken('a');

        if ($uValidate['status'] === false) {
            return response()->json(ResponseJson('', false, $uValidate['message']), Http(401));
        }
        return response()->json(ResponseJson($this->candidatos, true, []), Http(200));
    }

    public function GetLeadId(Request $request)
    {
        $id = $request->id;

        if ($id && is_numeric($id)) {
            $uValidate = ValidateToken('g');

            if ($uValidate['status'] === false) {
                return response()->json(ResponseJson('', false, $uValidate['message']), Http(401));
            }
            $iData = GetDataId($id,  $uValidate['user'], $this->candidatos);
            if ($iData['status'] === false) {
                return response()->json(ResponseJson('', false, $iData['message']), Http(401));
            }
            return response()->json(ResponseJson($iData['data'], true,), Http(200));
        } else {
            return response()->json(ResponseJson('', false, ['Invalid Id']), Http(401));
        }
    }
}
