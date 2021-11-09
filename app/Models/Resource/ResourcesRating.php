<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Model;

class ResourcesRating extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resources_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resources_id', 'voter_user_id',
        'rating', 'updated_at'
    ];
}
