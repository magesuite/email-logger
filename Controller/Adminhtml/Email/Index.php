<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Controller\Adminhtml\Email;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_EmailLogger::email';

    protected \Magento\Framework\View\Result\PageFactory $pageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('MageSuite_EmailLogger::email_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Email Logs'));

        return $resultPage;
    }
}
