<?php

use Illuminate\Support\Facades\Http;
use function Pest\Laravel\getJson;

it('returns string data type', function () {

    $url = '/api/authors';

    $response_data = [
        "data" => [
            "returnType" => "string",
            "paginate" => false,
            "result" => "dfadflabdfa",
            "message" => "Malumotlar saqlandi"
        ]
    ];

    $this->post([
        $url => Http::response($response_data, 200)
    ]);

    $response = getJson($url);

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

it('returns number data type', function () {

    $url = '/api/authors';


    $response_data = [
        "data" => [
            "returnType" => "number",
            "paginate" => false,
            "result" => 12,
            "message" => "Malumotlar saqlandi"
        ]
    ];

    $this->post([
        $url => Http::response($response_data, 200)
    ]);

    $response = getJson($url);
    $response->assertStatus(200);
    $response->assertJson([
        "data" => [
            "returnType" => "number",
            "paginate" => false,
            "result" => 12,
            "message" => "Malumotlar saqlandi"
        ]
    ]);
});

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });
