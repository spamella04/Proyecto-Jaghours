<?php

namespace App\Decorator\Applications;

abstract class ApplicationHandler
{
    protected $applications;

    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    abstract public function render();
}