<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Controller\Adminhtml\Email;

class View extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_EmailLogger::email';

    protected \Magento\Framework\Controller\Result\RawFactory $resultRawFactory;

    protected \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository
    ) {
        $this->resultRawFactory = $resultRawFactory;
        $this->emailRepository = $emailRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('email_id');

        if ($id) {
            $model = $this->emailRepository->getById($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This email no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents($model->getContent());

        return $resultRaw;
    }
}
