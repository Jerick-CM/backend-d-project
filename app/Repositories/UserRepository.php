<?php

namespace App\Repositories;

use App\Models\User;
use Takaworx\Brix\Traits\RepositoryTrait;

class UserRepository extends User
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Search for user
     *
     * @param string @field
     * @param string @value
     */
    public function search($field, $value)
    {
        $values = explode(' ', $value);

        $query = $this;

        foreach ($values as $v) {
            $query = $query->where($field, 'like', "%$v%");
        }

        return $query;
    }

    ///////////////// DEPECRATED METHODS /////////////////

    /**
     * Add credits to user
     *
     * @param int $id - id of the user
     * @param int $credits - no. of credits to be added
     */
    public function addCredits($id, $credits)
    {
        return $this->where('id', $id)->increment('credits', $credits);
    }
}
