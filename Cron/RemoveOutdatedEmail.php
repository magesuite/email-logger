<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Cron;

class RemoveOutdatedEmail
{
    protected \MageSuite\EmailLogger\Model\ResourceModel\Email $emailResource;

    public function __construct(\MageSuite\EmailLogger\Model\ResourceModel\Email $emailResource)
    {
        $this->emailResource = $emailResource;
    }

    public function execute(): void
    {
        $this->emailResource->clean();
    }
}
