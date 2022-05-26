<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Controller\Adminhtml\Email;

class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_EmailLogger::email';

    protected \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository
    ) {
        $this->emailRepository = $emailRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('email_id');

        if ($id) {
            try {
                $this->emailRepository->deleteById($id);
                $this->messageManager->addSuccess(__('You deleted the email log item.'));

                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['email_id' => $id]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a email log item to delete.'));

        return $resultRedirect->setPath('*/*/index');
    }
}
