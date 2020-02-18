<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */
declare(strict_types=1);

namespace Codilar\BannerSlider\Api\Data;


interface ResourceMapInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setTitle(string $title): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @return int|null
     */
    public function getMinWidth(): ?int;

    /**
     * @param int|null $minWidth
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setMinWidth(?int $minWidth): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @return int|null
     */
    public function getMaxWidth(): ?int;

    /**
     * @param int|null $maxWidth
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setMaxWidth(?int $maxWidth): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setCreatedAt(string $createdAt): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function setUpdatedAt(string $updatedAt): \Codilar\BannerSlider\Api\Data\ResourceMapInterface;
}