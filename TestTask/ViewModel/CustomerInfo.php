<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\ViewModel;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Pereviazko\TestTask\Api\GetCustomerStatusInterface;
use Pereviazko\TestTask\Api\SaveCustomerStatusInterface;

class CustomerInfo implements ArgumentInterface
{
    /**
     * @var GetCustomerStatusInterface
     */
    private $getCustomerStatus;

    /**
     * CustomerInfo constructor
     *
     * @param GetCustomerStatusInterface $getCustomerStatus
     */
    public function __construct(
        GetCustomerStatusInterface $getCustomerStatus
    )
    {
        $this->getCustomerStatus = $getCustomerStatus;
    }

    /**
     * @return string|null
     */
    public function getCustomerStatus(): ?string
    {
        return $this->getCustomerStatus->execute();
    }
}
