<?php

namespace App\Repositories;

use App\Models\ContactEmail;
use Takaworx\Brix\Traits\RepositoryTrait;

class ContactRepository extends ContactEmail
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'contact_emails';
}
