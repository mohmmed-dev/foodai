<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Content;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ai.result.{contentId}', function ($user, $contentId) {
    return true;
    // return (int) $user->id === (int) 54;
});
