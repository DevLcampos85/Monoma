<?php

use App\Models\Candidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

function Http($s = 200)
{
    switch ($s) {
        case '100':
            return Response::HTTP_CONTINUE;
            break;
        case '101':
            return Response::HTTP_SWITCHING_PROTOCOLS;
            break;
        case '102':
            return Response::HTTP_PROCESSING;
            break;
        case '200':
            return Response::HTTP_OK;
            break;
        case '201':
            return Response::HTTP_CREATED;
            break;
        case '202':
            return Response::HTTP_ACCEPTED;
            break;
        case '203':
            return Response::HTTP_NON_AUTHORITATIVE_INFORMATION;
            break;
        case '204':
            return Response::HTTP_NO_CONTENT;
            break;
        case '205':
            return Response::HTTP_RESET_CONTENT;
            break;
        case '206':
            return Response::HTTP_PARTIAL_CONTENT;
            break;
        case '207':
            return Response::HTTP_MULTI_STATUS;
            break;
        case '208':
            return Response::HTTP_ALREADY_REPORTED;
            break;
        case '226':
            return Response::HTTP_IM_USED;
            break;
        case '300':
            return Response::HTTP_MULTIPLE_CHOICES;
            break;
        case '301':
            return Response::HTTP_MOVED_PERMANENTLY;
            break;
        case '302':
            return Response::HTTP_FOUND;
            break;
        case '303':
            return Response::HTTP_SEE_OTHER;
            break;
        case '304':
            return Response::HTTP_NOT_MODIFIED;
            break;
        case '305':
            return Response::HTTP_USE_PROXY;
            break;
        case '306':
            return Response::HTTP_RESERVED;
            break;
        case '307':
            return Response::HTTP_TEMPORARY_REDIRECT;
            break;
        case '308':
            return Response::HTTP_PERMANENTLY_REDIRECT;
            break;
        case '400':
            return Response::HTTP_BAD_REQUEST;
            break;
        case '401':
            return Response::HTTP_UNAUTHORIZED;
            break;
        case '402':
            return Response::HTTP_PAYMENT_REQUIRED;
            break;
        case '403':
            return Response::HTTP_FORBIDDEN;
            break;
        case '404':
            return Response::HTTP_NOT_FOUND;
            break;
        case '405':
            return Response::HTTP_METHOD_NOT_ALLOWED;
            break;
        case '406':
            return Response::HTTP_NOT_ACCEPTABLE;
            break;
        case '407':
            return Response::HTTP_PROXY_AUTHENTICATION_REQUIRED;
            break;
        case '408':
            return Response::HTTP_REQUEST_TIMEOUT;
            break;
        case '409':
            return Response::HTTP_CONFLICT;
            break;
        case '410':
            return Response::HTTP_GONE;
            break;
        case '411':
            return Response::HTTP_LENGTH_REQUIRED;
            break;
        case '412':
            return Response::HTTP_PRECONDITION_FAILED;
            break;
        case '413':
            return Response::HTTP_REQUEST_ENTITY_TOO_LARGE;
            break;
        case '414':
            return Response::HTTP_REQUEST_URI_TOO_LONG;
            break;
        case '415':
            return Response::HTTP_UNSUPPORTED_MEDIA_TYPE;
            break;
        case '416':
            return Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE;
            break;
        case '417':
            return Response::HTTP_EXPECTATION_FAILED;
            break;
        case '418':
            return Response::HTTP_I_AM_A_TEAPOT;
            break;
        case '421':
            return Response::HTTP_MISDIRECTED_REQUEST;
            break;
        case '422':
            return Response::HTTP_UNPROCESSABLE_ENTITY;
            break;
        case '423':
            return Response::HTTP_LOCKED;
            break;
        case '424':
            return Response::HTTP_FAILED_DEPENDENCY;
            break;
        case '425':
            return Response::HTTP_TOO_EARLY;
            break;
        case '426':
            return Response::HTTP_UPGRADE_REQUIRED;
            break;
        case '428':
            return Response::HTTP_PRECONDITION_REQUIRED;
            break;
        case '429':
            return Response::HTTP_TOO_MANY_REQUESTS;
            break;
        case '431':
            return Response::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE;
            break;
        case '451':
            return Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
            break;
        case '500':
            return Response::HTTP_INTERNAL_SERVER_ERROR;
            break;
        case '501':
            return Response::HTTP_NOT_IMPLEMENTED;
            break;
        case '502':
            return Response::HTTP_BAD_GATEWAY;
            break;
        case '503':
            return Response::HTTP_SERVICE_UNAVAILABLE;
            break;
        case '504':
            return Response::HTTP_GATEWAY_TIMEOUT;
            break;
        case '505':
            return Response::HTTP_VERSION_NOT_SUPPORTED;
            break;
        case '506':
            return Response::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL;
            break;
        case '507':
            return Response::HTTP_INSUFFICIENT_STORAGE;
            break;
        case '508':
            return Response::HTTP_LOOP_DETECTED;
            break;
        case '510':
            return Response::HTTP_NOT_EXTENDED;
            break;
        case '511':
            return Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED;
            break;
        default:
            return Response::HTTP_OK;
            break;
    }
}

function ResponseJson($info = [], $status = true, $e = '')
{
    if ($status === true) {
        return [
            'meta' => [
                'success' => $status,
                'errors' => [],
            ],
            'data' => $info,
        ];
    }

    return [
        'meta' => [
            'success' => $status,
            'errors' => $e,
        ]
    ];
}

function ValidatorReponse($r = false, $ope = [])
{
    switch ($ope) {
        case 'a':
            $validator = Validator::make($r, ['username' => 'required', 'password' => 'required']);
            break;
        case 'r':
            $validator = Validator::make($r, ['name' => 'required', 'source' => 'required', 'owner' => 'required']);
            break;
        default:
            $validator = Validator::make($r, ['username' => 'required', 'password' => 'required']);
            break;
    }

    if ($validator->fails()) {
        return ['status' => 'error', 'message' => 'incomplete params'];
    }
    return ['status' => true, 'message' => ''];
}

function ValidateToken($t = 'a')
{
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return ['status' => false, 'message' => 'User not found'];
        }
    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return ['status' => false, 'message' => 'Token expired'];
    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return ['status' => false, 'message' => 'Token invalid'];
    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        return ['status' => false, 'message' => 'Token absent'];
    }

    if ($user->is_active === 0) {
        return ['status' => false, 'message' => 'Users not active'];
    }

    if (($t === 'r') && ($user->roles->name === "Manager")) {
        return ['status' => true, 'user' => $user, 'message' => 'Register - Only Manager'];
    } else if (($t === 'a') && ($user->roles->name === "Manager")) {
        return ['status' => true, 'user' => $user, 'message' => 'Get All - Only Manager'];
    } else if (($t === 'g') && (($user->roles->name === "Manager") || ($user->roles->name === "Agent"))) {
        return ['status' => true, 'user' => $user, 'message' => 'Get ID - Manager And Agent'];
    } else {
        return ['status' => false, 'message' => 'Insufficient Permits'];
    }

    return ['status' => true, 'user' => $user];
}

function GetDataId($id = 1, $p = [], $cand = [])
{
    $iData = false;
    if ($p->roles->name === "Manager") {
        foreach ($cand as $can) {
            if (((int)$can->id == (int)$id) === true) {
                $iData = $can;
            }
        }
        $message = ($iData === false) ? 'Candidate not found' : '';
    } else {
        $f = $o = 0;
        foreach ($cand as $can) {
            if (($can->id == $id) == true) {
                $f = 1;
                if (($can->owner == $p->id) == true) {
                    $iData = $can;
                    $o = 1;
                }
            }
        }
        if ($f == 0) {
            $message = 'Candidate not found';
        } else if ($f == 1) {
            $message = ($o == 0) ? 'You are not an owner' : '';
        }
    }

    if (!$iData == false) {
        return ['status' => true, 'data' => $iData, 'message' => $message];
    } else {
        return ['status' => false, 'data' => $iData, 'message' => $message];
    }
}

function CacheUpdate($c = 'Users')
{
    $forget = Cache::forget($c);
    $cache = Cache::remember($c, 84600, function () {
        return User::get();
    });
    return true;
}
