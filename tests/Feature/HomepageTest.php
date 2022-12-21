<?php

it('has homepage page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('asks for school username', function() {
    $response = $this->get('/');
    $response->assertStatus(200)->assertSee("Your School Username");
});

it('handles invalid usernames', function() {
    $response = $this->get('setup?username=invalidusernmame239ewr78fdy8');
    $response->assertStatus(302); // becuase of the ValidationException
});
