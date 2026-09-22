<?php

it('registers the API category routes without class conflicts', function () {
    $response = $this->getJson('/api/categories');

    $response->assertStatus(200);
});
