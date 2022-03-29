<?php

namespace App\Models\Resource;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Support\Jsonable;

class Resource extends Model implements  Jsonable
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'lang_id', 'creator_user_id',
        'admin_user_id', 'img_path', 'status_id', 'pdf_path', 'type_id', 'description', 'difficulty_id',
        'avg_rating', 'display_in_api'
    ];


    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_user_id');
    }


    public function ratings(): HasMany {
        return $this->hasMany(
            ResourcesRating::class,
            'resources_id',
            'id'
        );
    }



}
