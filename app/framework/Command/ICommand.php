<?php

declare(strict_types = 1);

namespace Framework\Command;

interface ICommand
{
    public function execute(): void;
}