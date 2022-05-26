<?php
declare(strict_types=1);

namespace MageSuite\EmailLogger\Ui\Component\Listing\Column;

class EmailActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected \Magento\Framework\UrlInterface $urlBuilder;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['email_id'])) {
                continue;
            }

            $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
            $deleteUrlPath = $this->getData('config/deleteUrlPath') ?: '#';
            $emailParamName = 'email_id';
            $title = $item[$emailParamName];
            $item[$this->getData('name')] = [
                'view' => [
                    'href' => $this->urlBuilder->getUrl(
                        $viewUrlPath,
                        [
                            $emailParamName => $item[$emailParamName]
                        ]
                    ),
                    'label' => __('View'),
                    'target' => '_blank'
                ],
                'delete' => [
                    'href' => $this->urlBuilder->getUrl(
                        $deleteUrlPath,
                        [
                            $emailParamName => $item[$emailParamName]
                        ]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete record #%1', $title),
                        'message' => __('Are you sure you want to delete a record #%1?', $title)
                    ],
                    'post' => true
                ]
            ];
        }

        return $dataSource;
    }
}
