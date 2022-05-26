<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Plugin\Framework\Mail\TransportInterface;

class SaveEmailLog
{
    protected \MageSuite\EmailLogger\Helper\Configuration $configuration;

    protected \MageSuite\EmailLogger\Api\Data\EmailInterfaceFactory $emailFactory;

    protected \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository;

    protected \Psr\Log\LoggerInterface $logger;

    public function __construct(
        \MageSuite\EmailLogger\Helper\Configuration $configuration,
        \MageSuite\EmailLogger\Api\Data\EmailInterfaceFactory $emailFactory,
        \MageSuite\EmailLogger\Api\EmailRepositoryInterface $emailRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->configuration = $configuration;
        $this->emailFactory = $emailFactory;
        $this->emailRepository = $emailRepository;
        $this->logger = $logger;
    }

    public function afterSendMessage(
        \Magento\Framework\Mail\TransportInterface $subject,
        $result
    ) {
        if (!$this->configuration->isEnabled()) {
            return $result;
        }

        try {
            $message = $subject->getMessage();
            $email = $this->emailFactory->create()
                ->setRecipient($message->getTo()[0]->getEmail())
                ->setSender($message->getFrom()[0]->getEmail())
                ->setSubject($message->getSubject())
                ->setBody($message->getBody()->getParts()[0]->getRawContent());
            $this->emailRepository->save($email);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $result;
    }
}
