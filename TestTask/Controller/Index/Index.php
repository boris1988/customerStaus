<?php
namespace Pereviazko\TestTask\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Default customer account page
     *
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
