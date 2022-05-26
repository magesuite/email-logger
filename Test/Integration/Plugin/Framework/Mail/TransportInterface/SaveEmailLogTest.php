<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Test\Integration\Plugin\Framework\Mail\TransportInterface;

class SaveEmailLogTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \MageSuite\EmailLogger\Api\EmailRepositoryInterface
     */
    protected $emailRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->transportBuilder = $objectManager->get(\Magento\Framework\Mail\Template\TransportBuilder::class);
        $this->emailRepository = $objectManager->get(\MageSuite\EmailLogger\Api\EmailRepositoryInterface::class);
        $this->searchCriteriaBuilder = $objectManager->get(\Magento\Framework\Api\SearchCriteriaBuilder::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoConfigFixture default/email_logger/general/enabled 1
     */
    public function testIfEmailIsSavedInTheDatabase()
    {
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('contact_email_email_template')
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
            ->setTemplateVars([])
            ->setFrom(['name' => 'Example From','email' => 'from@example.com'])
            ->addTo('to@example.com', 'Example To')
            ->getTransport();
        $transport->sendMessage();
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->emailRepository->getList($searchCriteria)->getItems();
        $email = array_pop($items);

        $this->assertEquals('to@example.com', $email->getRecipient());
        $this->assertEquals('from@example.com', $email->getSender());
        $this->assertEquals('Contact Form', $email->getSubject());
    }
}
