<?php

namespace App\Repositories;

use App\Traits\ApiResponser;
use App\Interfaces\ExampleInterface;

class ExampleRepository implements ExampleInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getData()
    {
        //
    }
}
