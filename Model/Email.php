<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Model;

class Email extends \Magento\Framework\Model\AbstractModel implements \MageSuite\EmailLogger\Api\Data\EmailInterface
{
    protected function _construct()
    {
        $this->_init(\MageSuite\EmailLogger\Model\ResourceModel\Email::class);
    }

    public function getEmailId()
    {
        return $this->_getData(self::EMAIL_ID);
    }

    public function setEmailId(int $emailId)
    {
        return $this->setData(self::EMAIL_ID, $emailId);
    }

    public function getRecipient()
    {
        return $this->_getData(self::RECIPIENT);
    }

    public function setRecipient(string $recipient)
    {
        return $this->setData(self::RECIPIENT, $recipient);
    }

    public function getSender()
    {
        return $this->_getData(self::SENDER);
    }

    public function setSender(string $sender)
    {
        return $this->setData(self::SENDER, $sender);
    }

    public function getSubject()
    {
        return $this->_getData(self::SUBJECT);
    }

    public function setSubject(string $subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    public function getBody()
    {
        return $this->_getData(self::BODY);
    }

    public function setBody(string $body)
    {
        return $this->setData(self::BODY, $body);
    }

    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
