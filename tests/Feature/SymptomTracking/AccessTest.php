<?php

namespace Tests\Feature\SymptomTracking;

use App\Models\Profile;
use App\Models\User;

it ("blocks access to another user's profile", function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $user1Profile = Profile::factory()->create(['user_id' => $user1->id]);
    $user2Profile = Profile::factory()->create(['user_id' => $user2->id]);

    $this
        ->actingAs($user1)
        ->get(route("track.index", $user1Profile))
        ->assertOk();

    $this
        ->actingAs($user1)
        ->get(route("track.index", $user2Profile))
        ->assertForbidden();
});