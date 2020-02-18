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

interface ResourceMapRepositoryInterface
{
    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function create(): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;
    
    /**
     * @param \Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @param \Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap): bool;

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @return \Codilar\BannerSlider\Model\ResourceModel\ResourceMap\Collection
     */
    public function getCollection(): \Codilar\BannerSlider\Model\ResourceModel\ResourceMap\Collection;
}