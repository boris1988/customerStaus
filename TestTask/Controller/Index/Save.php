<?php
declare(strict_types=1);

namespace Pereviazko\TestTask\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Pereviazko\TestTask\Api\SaveCustomerStatusInterface;

class Save implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var SaveCustomerStatusInterface
     */
    private $customerStatus;

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    public function __construct(
        RequestInterface $request,
        SaveCustomerStatusInterface $customerStatus,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->customerStatus = $customerStatus;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $params = $this->request->getPostValue();
        if (!isset($params[SaveCustomerStatusInterface::CUSTOMER_STATUS_ATTRIBUTE])) {
            $this->messageManager->addErrorMessage(__('Incorrect request params'));
        }
        $this->customerStatus->execute($params[SaveCustomerStatusInterface::CUSTOMER_STATUS_ATTRIBUTE]);
        $this->messageManager->addSuccessMessage(__('Customer Status saved'));

        return $this->redirectFactory->create()->setPath('testtask/index/index');
    }
}
