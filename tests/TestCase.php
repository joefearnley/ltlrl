<?php

namespace Tests;

use App\User;
use App\Click;
use App\Url;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
