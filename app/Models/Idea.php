<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory,Sluggable;
    const PAGINATION_COUNT = 10;
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function isVotedByUser(?User $user)
    {
        if (!$user) {
            return false;
        }

        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function getStatusClasses()
    {
        $all_statuses = [
            'Open' => 'bg-gray-200',
            'Considering' => 'bg-gray-200',
            'In Progress' => 'bg-gray-200',
            'Implemented' => 'bg-gray-200',
            'Closed' => 'bg-gray-200'
//            'Considering' => 'bg-purple text-white',
//            'In Progress' => 'bg-yellow text-white',
//            'Implemented' => 'bg-green text-white',
//            'Closed' => 'bg-red text-white'
        ];
        return $all_statuses[$this->status->name];
    }


}
