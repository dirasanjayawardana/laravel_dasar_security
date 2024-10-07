<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $value = "Dira Sanjaya Wardana";

        $encrypted = Crypt::encryptString($value);
        $decrypted = Crypt::decryptString($encrypted);

        self::assertEquals($value, $decrypted);
    }

}
