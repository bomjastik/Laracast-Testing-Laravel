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

    public function add(User $member)
    {
        $this->guardAgainstTooManyMembers();

        $this->members()->save($member);
    }

    public function addMany(Collection $members)
    {
        $members->each(function ($member, $key) {
            $this->add($member);
        });
    }

    public function remove(User $member)
    {
        $member->leaveTeam();
    }

    public function removeMany(Collection $members)
    {
        $members->each(function ($member, $key) {
            $this->remove($member);
        });
    }

    public function clean()
    {
        $this->removeMany($this->members);
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
}
