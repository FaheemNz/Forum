<?php
namespace App\Interfaces;

interface SpamInterface
{
    public function detect(string $text);
}