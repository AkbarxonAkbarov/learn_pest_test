<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;

it('returns string data type', function () {

    $url = '/api/authors';
    $user = new User();
    $user->name = 'fullname';
    $user->username = 'username';
    $user->password = bcrypt('password');
    $user->save();

    $token = $user->createToken("test_token");
    $response = $this->withHeaders([
        "Authorization" => "Bearer " . $token->plainTextToken,
        "Accept" => "application/json",
    ])->get($url);

    $response->assertStatus(200);
    $response->assertJson([
        "data" => [
            "returnType" => "string",
            "paginate" => false,
            "result" => "dfadflabdfa",
            "message" => "Malumotlar saqlandi"
        ]
    ]);
});

