<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as ResourceCustomer;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use Pereviazko\TestTask\Api\SaveCustomerStatusInterface;

class SaveCustomerStatus implements SaveCustomerStatusInterface
{
    /**
     * @var CustomerInterfaceFactory
     */
    private $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * SaveCustomerStatus constructor.
     * @param CustomerFactory $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        CurrentCustomer $currentCustomer
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @param string $customerStatus
     * @return $this|SaveCustomerStatusInterface
     * @throws InputException
     * @throws LocalizedException
     * @throws InputMismatchException
     */
    public function execute(string $customerStatus): SaveCustomerStatusInterface
    {
        $customerId = $this->currentCustomer->getCustomerId();
        /** @var Customer $customer */
        $customerData = $this->customerRepository->getById($customerId);
        //$customerData = $customer->getDataModel();
        $customerData->setCustomAttribute(SaveCustomerStatusInterface::CUSTOMER_STATUS_ATTRIBUTE ,$customerStatus);
        $this->customerRepository->save($customerData);

        return $this;
    }
}
