<?php
namespace App\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Client;
use Carbon\Carbon;

class RevokeOldTokens {
    public function __construct() {
        //
    }
    public function handle(AccessTokenCreated $event) {
        $client = Client::find($event->clientId);
        // delete this client tokens created before one day ago:
        $client->tokens()
                  ->where('user_id', $event->userId)
                  ->where('created_at', '<', Carbon::now())
                  ->delete();
    }
}