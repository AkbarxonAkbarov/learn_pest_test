<?php

use Illuminate\Testing\Fluent\AssertableJson;

it("4-check return type", function () {
    $response = $this->get("/api/fourth");

    $response->assertStatus(200);
    $response->assertJson(
        fn(AssertableJson $json) =>
        $json->whereType('data.result.data', 'array')
            ->has('data.result.data', request('count'))
            ->whereType('data.result.links', 'array')
            ->has('data.result.links', 3)
            ->whereType('data.result.meta', 'array')
            ->has('data.result.meta', 7)

    );
    $userData = $response->json('data.result.data');
    $linkData = $response->json('data.result.links');
    $metaData = $response->json('data.result.meta');
    $mainData = $response->json('data');
    expect($mainData)->toHaveKeys(['returnType', 'paginate', 'result']);
    expect($mainData['returnType'])->toBeString()->toBe('collection');
    expect($mainData['paginate'])->toBeTrue();


    expect($userData)->toBeArray();
    expect($userData)->each->toBeArray();

    expect($linkData)->toHaveKeys(['first', 'prev', 'next'])->toBeArray();
    expect($metaData)->toHaveKeys(['first_page_url', 'from', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to'])->toBeArray();

    expect($linkData['first'])->toBeUrl();
    $linkData['prev'] === null ? expect($linkData['prev'])->toBeNull() : expect($linkData['prev'])->toBeUrl();
    $linkData['next'] === null ? expect($linkData['next'])->toBeNull() : expect($linkData['next'])->toBeUrl();


    expect($metaData['first_page_url'])->toBeUrl();
    expect($metaData['from'])->toBeInt()->toBeGreaterThanOrEqual(1);
    $metaData['next_page_url'] === null ? expect($metaData['next_page_url'])->toBeNull() : expect($metaData['next_page_url'])->toBeUrl();
    expect($metaData['path'])->toBeUrl();
    expect($metaData['per_page'])->toBeInt()->toBeGreaterThan(0);
    expect($metaData['to'])->toBeInt()->toBeGreaterThan(0);

    foreach ($userData as $item) {
        expect($item['id'])->toBeInt();
        expect($item['name'])->toBeString();
    }
});
