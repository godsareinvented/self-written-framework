<?php

namespace App\Controller;

class TestController implements ControllerInterface
{
    public function test(): void {
        echo 'Test message.';
    }
}