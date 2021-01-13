<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\SearchBuilders\UserSearchBuilder;

class UsersController extends Controller
{
    public function index(Request $request, UserSearchBuilder $builder){

        $keywords = array_filter(explode(' ', $request->input('keywords', '')));

        return $builder->keywords($keywords)->query()->limit(5)->get()->toArray();
    }
}
