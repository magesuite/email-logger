<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Model;

class EmailRepository implements \MageSuite\EmailLogger\Api\EmailRepositoryInterface
{
    /**
     * @var \MageSuite\EmailLogger\Api\Data\EmailInterface[]
     */
    protected $instancesById = [];

    protected \MageSuite\EmailLogger\Model\EmailFactory $emailFactory;

    protected \MageSuite\EmailLogger\Model\ResourceModel\Email $emailResource;

    protected \MageSuite\EmailLogger\Model\ResourceModel\Email\CollectionFactory $collectionFactory;

    protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory;

    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        \MageSuite\EmailLogger\Model\EmailFactory $emailFactory,
        \MageSuite\EmailLogger\Model\ResourceModel\Email $emailResource,
        \MageSuite\EmailLogger\Model\ResourceModel\Email\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->emailFactory = $emailFactory;
        $this->emailResource = $emailResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $emailId
     * @return \MageSuite\EmailLogger\Api\Data\EmailInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($emailId)
    {
        if (!isset($this->instancesById[$emailId])) {
            $email = $this->emailFactory->create();
            $email->load($emailId);
            $this->instancesById[$emailId] = $email;
        }

        if (!$this->instancesById[$emailId]->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The email with the "%1" ID doesn\'t exist.', $emailId)
            );
        }

        return $this->instancesById[$emailId];
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \MageSuite\EmailLogger\Model\ResourceModel\Email\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        foreach ($collection->getItems() as $email) {
            $this->instancesById[$email->getId()] = $email;
        }

        /** @var \Magento\Framework\Api\SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->count());

        return $searchResults;
    }

    /**
     * @param \MageSuite\EmailLogger\Api\Data\EmailInterface $email
     * @return \MageSuite\EmailLogger\Api\Data\EmailInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\MageSuite\EmailLogger\Api\Data\EmailInterface $email)
    {
        try {
            $this->emailResource->save($email);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the email: %1', $exception->getMessage()),
                $exception
            );
        }

        return $email;
    }

    /**
     * @param \MageSuite\EmailLogger\Api\Data\EmailInterface $email
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function delete(\MageSuite\EmailLogger\Api\Data\EmailInterface $email)
    {
        try {
            $this->emailResource->delete($email);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not delete the email: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param int $emailId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($emailId)
    {
        return $this->delete($this->getById($emailId));
    }
}
