<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testIsSuperAdmin()
    {
        $superAdmin = new User(['super_admin' => true]);
        $this->assertTrue($superAdmin->isSuperAdmin());

        $regularUser = new User(['super_admin' => false]);
        $this->assertFalse($regularUser->isSuperAdmin());
    }
}