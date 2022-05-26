<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_GENERAL_ENABLED = 'email_logger/general/enabled';
    public const XML_PATH_GENERAL_RETENTION_PERIOD_IN_DAYS = 'email_logger/general/retention_period_in_days';

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_GENERAL_ENABLED);
    }

    public function getRetentionPeriodInDays(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_GENERAL_RETENTION_PERIOD_IN_DAYS);
    }
}
