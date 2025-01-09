<?php

use Tests\TestCase;
//  use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Author;
use Database\Factories\UserFactory;

it("has authorization check", function () {
    $response = $this->withHeaders(["Accept" => "application/json"])->get("/api/authors");

    $response->assertStatus(401);
});


it("returns success http status code", function () {
    $user = new User();
    $user->name = 'fullname';
    $user->username = 'username';
    $user->password = bcrypt('password');
    $user->save();

    $token = $user->createToken("test_token");

    $response = $this->withHeaders([
        "Authorization" => "Bearer " . $token->plainTextToken,
        "Accept" => "application/json",
    ])
        ->get('/api/authors');

    $response->assertStatus(200);
});

it("shows list of clients with pagination", function () {
    $user = new User();
    $user->name = UserFactory::new()->definition()['name'];
    $user->username = 'username2';
    $user->password = bcrypt('password');
    $user->save();

    $token = $user->createToken("test_token");

    $response = $this
        ->withHeaders([
            "Authorization" => "Bearer " . $token->plainTextToken,
            "Accept" => "application/json",
        ])
        ->get('/api/paginate_authors');


    $response->assertStatus(200);
    $data = $response->json('data');
    expect($data)->toHaveKeys(['result', 'paginate', 'returnType']);
    expect($data['returnType'])->tobe('collection');
    expect($data['paginate'])->toBeTrue();
    expect($data['result'])->toBeArray();
    // expect($data['result'])->toHaveCount(10);

});

it("checks error response in error case", function () {
    $user = new User();
    $user->name = UserFactory::new()->definition()['name'];
    $user->username = 'test';
    $user->password = bcrypt('password');
    $user->save();

    $token = $user->createToken("test_token");

    $response = $this
        ->withHeaders([
            "Authorization" => "Bearer " . $token->plainTextToken,
            "Accept" => "application/json",
        ])
        ->get('/api/authors?error=true');

    $response->assertStatus(400);
    $data = $response->json('message');
    expect($data)->toBe("error message");
});
