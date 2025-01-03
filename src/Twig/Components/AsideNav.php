<?php

namespace App\Twig\Components;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class AsideNav {
    public string $userId;
    public string $username;
    public $form;
}