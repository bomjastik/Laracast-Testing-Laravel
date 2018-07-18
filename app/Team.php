<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'size'
    ];

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function add($members)
    {
        $this->guardAgainstTooManyMembers();

        if ($members instanceof User) {
            $members = [$members];
        }

        if ($this->isCountable($members)) {
            $this->members()->saveMany($members);
        }
    }

    public function remove($members)
    {
        if ($members instanceof User) {
            $members = [$members];
        }

        if ($this->isCountable($members)) {
            foreach ($members as $member) {
                $member->team()->dissociate()->save();
            }
        }
    }

    public function clean()
    {
        foreach ($this->members as $member) {
            $member->team()->dissociate()->save();
        }
    }

    public function count()
    {
        return $this->members()->count();
    }

    private function guardAgainstTooManyMembers(): void
    {
        if ($this->count() >= $this->size) {
            throw new \Exception;
        }
    }

    /**
     * @param $members
     * @return bool
     */
    private function isCountable($members): bool
    {
        return $members instanceof Collection || is_array($members);
    }
}
