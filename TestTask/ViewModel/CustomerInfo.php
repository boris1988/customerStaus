<?php

namespace Pereviazko\TestTask\ViewModel;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Pereviazko\TestTask\Api\SaveCustomerStatusInterface;

class CustomerInfo implements ArgumentInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * ViewModel constructor
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CurrentCustomer $currentCustomer
    )
    {
        $this->customerRepository = $customerRepository;
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @return string|null
     */
    public function getCustomerStatus(): ?string
    {
        $customerId = $this->currentCustomer->getCustomerId();
        /** @var Customer $customer */
        try {
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException $e) {
            return '';
        } catch (LocalizedException $e) {
            return '';
        }
        $customAttribute = $customer->getCustomAttribute(
            SaveCustomerStatusInterface::CUSTOMER_STATUS_ATTRIBUTE
        );

        return $customAttribute !== null ? $customAttribute->getValue() : null;
    }
}
