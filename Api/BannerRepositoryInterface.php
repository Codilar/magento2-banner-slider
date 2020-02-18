<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */
declare(strict_types=1);

namespace Codilar\BannerSlider\Api;

interface BannerRepositoryInterface
{
    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function create(): \Codilar\BannerSlider\Api\Data\BannerInterface;
    
    /**
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface $banner
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Codilar\BannerSlider\Api\Data\BannerInterface $banner): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface $banner
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Codilar\BannerSlider\Api\Data\BannerInterface $banner): bool;

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Codilar\BannerSlider\Api\Data\BannerSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @return \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection
     */
    public function getCollection(): \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection;
}