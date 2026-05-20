<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToGarage
{
    protected static function bootBelongsToGarage()
    {
        // Add global scope to automatically filter by the authenticated user's garage_id
        static::addGlobalScope('garage', function (Builder $builder) {
            if (auth()->check()) {
                $user = auth()->user();
                
                // If the user has a garage_id, filter by it.
                // Assuming Super Admins might not have a garage_id and can see everything.
                if ($user->garage_id) {
                    $builder->where('garage_id', $user->garage_id);
                }
            }
        });

        // Automatically set the garage_id when creating a new model
        static::creating(function ($model) {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->garage_id && empty($model->garage_id)) {
                    $model->garage_id = $user->garage_id;
                }
            }
        });
    }
}
