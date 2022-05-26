<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Model\ResourceModel;

class Email extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected \MageSuite\EmailLogger\Helper\Configuration $configuration;

    protected \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \MageSuite\EmailLogger\Helper\Configuration $configuration,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        $connectionName = null
    ) {
        $this->configuration = $configuration;
        $this->date = $date;
        parent::__construct($context, $connectionName);
    }

    protected function _construct(): void
    {
        $this->_init('email_log', 'email_id');
    }

    public function clean(): self
    {
        $daysAgo = $this->configuration->getRetentionPeriodInDays();

        if (!$daysAgo) {
            return $this;
        }

        $cleanTime = $this->date->date(
            new \DateTime("{$daysAgo} days ago")
        )->format('Y-m-d H:i:s');
        $connection = $this->getConnection();

        while (true) {
            $select = $connection->select()
                ->from($this->getMainTable(), $this->getIdFieldName())
                ->where('created_at < ?', $cleanTime)
                ->limit(500);
            $emailIds = $connection->fetchCol($select);

            if (!$emailIds) {
                break;
            }

            $condition = [$this->getIdFieldName() . ' IN (?)' => $emailIds];
            $connection->delete($this->getMainTable(), $condition);
        }

        return $this;
    }
}
