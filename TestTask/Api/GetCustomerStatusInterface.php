<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\Api;


interface GetCustomerStatusInterface
{
    public function execute(): ?string;
}
