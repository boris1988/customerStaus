<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\Api;


interface SaveCustomerStatusInterface
{
    public const CUSTOMER_STATUS_ATTRIBUTE = 'customer_status';

    public function execute(string $customerStatus): SaveCustomerStatusInterface;
}
