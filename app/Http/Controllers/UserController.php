<?php

namespace App\Http\Controllers;

use App\Http\Resources\FourthTestResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function fourth()
    {
        $users = User::select('id', 'name')->simplePaginate(request('count', 15));
        // $users = User::where('name', 'asfdsfsd')->simplePaginate();
        return response()->json([
            'data' => [
                'returnType' => 'collection',
                'paginate' => true,
                'result' => new FourthTestResource($users)
            ]
        ], 200);
    }
}
