<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */
declare(strict_types=1);

namespace Codilar\BannerSlider\Api;

interface SliderRepositoryInterface
{
    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function create(): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @param \Codilar\BannerSlider\Api\Data\SliderInterface $slider
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Codilar\BannerSlider\Api\Data\SliderInterface $slider): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @param \Codilar\BannerSlider\Api\Data\SliderInterface $slider
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Codilar\BannerSlider\Api\Data\SliderInterface $slider): bool;

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Codilar\BannerSlider\Api\Data\SliderSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @return \Codilar\BannerSlider\Model\ResourceModel\Slider\Collection
     */
    public function getCollection(): \Codilar\BannerSlider\Model\ResourceModel\Slider\Collection;
}