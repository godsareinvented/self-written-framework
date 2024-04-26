<?php

namespace App\Controller;

class StartController implements ControllerInterface
{
    public function mainPage(): void {
        echo 'Main page.';
    }
}