<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Api;

interface EmailRepositoryInterface
{
    /**
     * @param int $emailId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \MageSuite\EmailLogger\Api\Data\EmailInterface
     */
    public function getById($emailId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param \MageSuite\EmailLogger\Api\Data\EmailInterface $email
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return bool
     */
    public function save(\MageSuite\EmailLogger\Api\Data\EmailInterface $email);

    /**
     * @param \MageSuite\EmailLogger\Api\Data\EmailInterface $email
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return bool
     */
    public function delete(\MageSuite\EmailLogger\Api\Data\EmailInterface $email);

    /**
     * @param int $emailId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return bool
     */
    public function deleteById($emailId);
}
