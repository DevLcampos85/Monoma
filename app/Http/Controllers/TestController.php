<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use JWTAuth;

class TestController extends Controller
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

    public function test(Request $request)
    {
        dd("TestController");
    }
}
