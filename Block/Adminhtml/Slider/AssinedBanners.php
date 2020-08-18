<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Block\Adminhtml\Slider;


use Codilar\BannerSlider\Api\BannerRepositoryInterface;
use Codilar\BannerSlider\Api\Data\BannerInterface;
use Codilar\BannerSlider\Ui\Component\Listing\Column\Banner\ResourcePath as ResourcePathBuilder;
use Magento\Backend\Block\Template;

class AssinedBanners extends Template
{
    protected $_template = 'Codilar_BannerSlider::slider/assigned_banners.phtml';
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var ResourcePathBuilder
     */
    private $resourcePathBuilder;

    /**
     * AssinedBanners constructor.
     * @param Template\Context $context
     * @param BannerRepositoryInterface $bannerRepository
     * @param ResourcePathBuilder $resourcePathBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        BannerRepositoryInterface $bannerRepository,
        ResourcePathBuilder $resourcePathBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->bannerRepository = $bannerRepository;
        $this->resourcePathBuilder = $resourcePathBuilder;
    }

    protected function getBanners()
    {
        $items = [];
        $collection = $this->bannerRepository->getCollection()->addFieldToFilter('slider_id', $this->getRequest()->getParam('entity_id'));
        /** @var BannerInterface $item */
        foreach ($collection as $item) {
            $itemData = $item->getData();
            $itemData['resource_map_title'] = $item->getResourceMap()->getTitle();
            $items[] = $itemData;
        }

        $dataSource = [
            'data' => [
                'items' => $items
            ]
        ];
        $dataSource = $this->resourcePathBuilder->prepareDataSource($dataSource);
        return $dataSource['data']['items'] ?? [];
    }

    public function getFormattedBanners()
    {
        $data = [];
        $banners = $this->getBanners();
        foreach ($banners as $banner) {
            if (!isset($data[$banner['resource_map_id']])) {
                $data[$banner['resource_map_id']] = [
                    'title' => $banner['resource_map_title'],
                    'banners' => []
                ];
            }
            $data[$banner['resource_map_id']]['banners'][] = $banner;
        }
        return $data;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getResourceMapUrl($id)
    {
        return $this->getUrl('*/resmap/edit', ['entity_id' => $id]);
    }

}
