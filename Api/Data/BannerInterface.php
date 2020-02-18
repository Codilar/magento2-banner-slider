<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */
declare(strict_types=1);

namespace Codilar\BannerSlider\Api\Data;


interface BannerInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getSliderId(): int;

    /**
     * @param int $sliderId
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setSliderId(int $sliderId): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return int
     */
    public function getResourceMapId(): int;

    /**
     * @param int $resourceMapId
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setResourceMapId(int $resourceMapId): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string|null
     */
    public function getResourceType(): ?string;

    /**
     * @param string|null $resourceType
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setResourceType(?string $resourceType): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string|null
     */
    public function getResourcePath(): ?string;

    /**
     * @param string|null $resourcePath
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setResourcePath(?string $resourcePath): \Codilar\BannerSlider\Api\Data\BannerInterface;
    
    /**
     * @return int
     */
    public function getIsEnabled(): int;

    /**
     * @param int $isEnabled
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setIsEnabled(int $isEnabled): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setCreatedAt(string $createdAt): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setUpdatedAt(string $updatedAt): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setTitle(string $title): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string
     */
    public function getAltText(): string;

    /**
     * @param string $altText
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setAltText(string $altText): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return string
     */
    public function getLink(): string;

    /**
     * @param string $link
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setLink(string $link): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return int
     */
    public function getSortOrder(): int;

    /**
     * @param int $sortOrder
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setSortOrder(int $sortOrder): \Codilar\BannerSlider\Api\Data\BannerInterface;

    /**
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface|null
     */
    public function getResourceMap(): ?\Codilar\BannerSlider\Api\Data\ResourceMapInterface;
}