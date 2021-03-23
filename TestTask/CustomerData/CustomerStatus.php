<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\DataObject;
use Pereviazko\TestTask\Api\GetCustomerStatusInterface;

class CustomerStatus extends DataObject implements SectionSourceInterface
{
    /**
     * @var GetCustomerStatusInterface
     */
    private $getCustomerStatus;

    public function __construct(
        GetCustomerStatusInterface $getCustomerStatus
    )
    {
        $this->getCustomerStatus = $getCustomerStatus;
    }

    /**
     * @return array
     */
    public function getSectionData(): array
    {
        return [
            'customer_status' => $this->getCustomerStatus->execute()
        ];
    }
}
