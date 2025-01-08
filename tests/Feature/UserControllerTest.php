<?php

use App\Models\User;
use App\Models\Author;

it("has authorization check", function () {
    $response = $this->withHeaders(["Accept" => "application/json"])->get("/api/authors");

    $response->assertStatus(401);
});


it("returns success http status code", function () {
    $user = new User();
    $user->name = 'test_user';
    $user->email = 'test_email';
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

it("shows list of clients without pagination", function () {
    $user = new User();
    $user->name = 'test_user';
    $user->email = 'test_email';
    $user->password = bcrypt('password');
    $user->save();

    $token = $user->createToken("test_token");

    $authorNames = ["author1", "author2"];
    $authors = [];

    foreach ($authorNames as $authorName) {
        $author = new Author();
        $author->name = $authorName;
        $author->save();

        $authors[] = $author;
    }

    $result = [];
    foreach ($authors as $author) {
        $result[] = [
            "id" => $author->id,
            "name" => $author->name,
        ];
    }

    $responseToAssert = [
        "data" => [
            "returnType" => "collection",
            "paginate" => false,
            "result" => $result,
        ]
    ];

    $response = $this
        ->withHeaders([
            "Authorization" => "Bearer " . $token->plainTextToken,
            "Accept" => "application/json",
        ])
        ->get('/api/authors');

    $response->assertJson($responseToAssert);
});

it("checks error response in error case", function () {
    $user = new User();
    $user->name = 'test_user';
    $user->email = 'test_email';
    $user->password = bcrypt('password');
    $user->save();
    $user->delete();
    $user->select("*")->get();

    $token = $user->createToken("test_token");

    $responseToAssert = [
        "data" => [
            "message" => "error message",
        ]
    ];

    $response = $this
        ->withHeaders([
            "Authorization" => "Bearer " . $token->plainTextToken,
            "Accept" => "application/json",
        ])
        ->get('/api/authors');

    $response->assertJson($responseToAssert);
});
