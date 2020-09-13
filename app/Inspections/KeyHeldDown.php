<?php

namespace App\Inspections;

use App\Interfaces\SpamInterface;

class KeyHeldDown implements SpamInterface
{
    public function detect(string $body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \App\Exceptions\SpamException('Your reply contains spam.');
        }
    }
}
