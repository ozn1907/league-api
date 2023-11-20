<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FavoriteService
{
    /**
     * Add a summoner to the user's favorites.
     *
     * @param \App\Models\User $user
     * @param string $favoriteName
     * @return array
     */
    public function addToFavorites(User $user, $favoriteName)
    {
        $validator = Validator::make(['favoriteName' => $favoriteName], [
            'favoriteName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['type' => 'error', 'message' => $validator->errors()->first()];
        }

        $existingFavorite = $user->favorites()->where('favorite_name', $favoriteName)->first();

        if ($existingFavorite) {
            return ['type' => 'info', 'message' => 'Summoner is already in favorites.'];
        }

        // If the favorite doesn't exist, create a new one
        $user->favorites()->create(['favorite_name' => $favoriteName]);

        return ['type' => 'success', 'message' => 'Summoner added to favorites.'];
    }
}
