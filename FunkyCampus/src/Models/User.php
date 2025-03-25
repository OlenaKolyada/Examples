<?php

declare(strict_types=1);

namespace App\Models;

use App\Repository;

class User extends Repository
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $phone;
    protected \DateTime $dateOfBirth;
    protected string $gender;
    protected \DateTime $createdAt;


}
