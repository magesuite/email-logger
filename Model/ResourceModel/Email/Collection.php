<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Model\ResourceModel\Email;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(\MageSuite\EmailLogger\Model\Email::class, \MageSuite\EmailLogger\Model\ResourceModel\Email::class);
    }
}
