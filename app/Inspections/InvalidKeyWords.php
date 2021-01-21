<?php

namespace App\Inspections;

use App\Interfaces\SpamInterface;

class InvalidKeyWords implements SpamInterface
{
    protected $invalidKeywords = ['Some Spam here'];

    public function detect(string $body)
    {
        foreach ($this->invalidKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \App\Exceptions\SpamException("Your post contains invalid words!");
            }
        }
    }
}
