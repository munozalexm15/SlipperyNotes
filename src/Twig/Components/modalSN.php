<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class modalSN {
    public bool $hasInputField;
    public string $message;
    public string $id;
    public string $modaltype;
}