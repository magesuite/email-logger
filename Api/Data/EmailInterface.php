<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Api\Data;

interface EmailInterface
{
    public const EMAIL_ID = 'email_id';
    public const RECIPIENT = 'recipient';
    public const SENDER = 'sender';
    public const SUBJECT = 'subject';
    public const BODY = 'body';
    public const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getEmailId();

    /**
     * @param int $emailId
     * @return EmailInterface
     */
    public function setEmailId(int $emailId);

    /**
     * @return string
     */
    public function getRecipient();

    /**
     * @param string $recipient
     * @return EmailInterface
     */
    public function setRecipient(string $recipient);

    /**
     * @return string
     */
    public function getSender();

    /**
     * @param string $sender
     * @return EmailInterface
     */
    public function setSender(string $sender);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @param string $subject
     * @return EmailInterface
     */
    public function setSubject(string $subject);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     * @return EmailInterface
     */
    public function setBody(string $body);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return EmailInterface
     */
    public function setCreatedAt(string $createdAt);
}
