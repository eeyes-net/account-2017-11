<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\Events\AccessTokenCreated;

class RevokeOldTokens
{
    /**
     * @param AccessTokenCreated $event
     * @link https://laravel.com/docs/5.3/passport#events
     * @link https://github.com/laravel/passport/issues/83#issuecomment-261000972
     */
    public function handle(AccessTokenCreated $event)
    {
        DB::table('oauth_access_tokens')
            ->where('id', '<>', $event->tokenId)
            ->where('user_id', '=', $event->userId)
            ->where('client_id', '=', $event->clientId)
            ->update([
                'revoked' => true,
            ]);
    }
}
