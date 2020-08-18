<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Resolver\DataProvider;


use Codilar\BannerSlider\Api\Data\BannerInterface;
use Codilar\BannerSlider\Api\Data\SliderInterface;
use Codilar\BannerSlider\Api\SliderRepositoryInterface;

class Slider
{
    /**
     * @var SliderRepositoryInterface
     */
    private $sliderRepository;

    /**
     * Slider constructor.
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        SliderRepositoryInterface $sliderRepository
    )
    {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @param $sliderId
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData($sliderId)
    {
        $data = [];
        $slider = $this->sliderRepository->loadById($sliderId);
        $data = $this->extractData($slider, [
            'slider_id' => 'entity_id',
            'title',
            'is_show_title',
            'is_enabled'
        ]);
        $data['banners'] = $this->getBanners($slider);
        return $data;
    }

    /**
     * @param SliderInterface $slider
     * @return array
     */
    protected function getBanners($slider)
    {
        $banners = [];
        foreach ($slider->getBanners() as $banner) {
            $bannerData = $this->extractData($banner, [
                'slider_id',
                'resource_type',
                'resource_path',
                'is_enabled',
                'title',
                'alt_text',
                'link',
                'sort_order'
            ]);
            $bannerData['resource_map'] = $this->getResourceMap($banner);
            $banners[] = $bannerData;
        }
        return $banners;
    }

    /**
     * @param BannerInterface $banner
     * @return array
     */
    protected function getResourceMap($banner)
    {
        $resourceMap = $banner->getResourceMap();
        return $this->extractData($resourceMap, [
            'title',
            'min_width',
            'max_width'
        ]);
    }

    /**
     * @param \Magento\Framework\DataObject $object
     * @param string[] $fields
     * @return array
     */
    protected function extractData($object, $fields)
    {
        $data = [];
        foreach ($fields as $key => $field) {
            if (is_numeric($key)) {
                $key = $field;
            }
            $data[$key] = $object->getData($field);
        }
        return $data;
    }
}
