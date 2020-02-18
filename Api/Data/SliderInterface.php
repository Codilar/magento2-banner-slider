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


interface SliderInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setTitle(string $title): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return int
     */
    public function getIsShowTitle(): int;

    /**
     * @param int $isShowTitle
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setIsShowTitle(int $isShowTitle): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return int
     */
    public function getIsEnabled(): int;

    /**
     * @param int $isEnabled
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setIsEnabled(int $isEnabled): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setCreatedAt(string $createdAt): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return \Codilar\BannerSlider\Api\Data\SliderInterface
     */
    public function setUpdatedAt(string $updatedAt): \Codilar\BannerSlider\Api\Data\SliderInterface;

    /**
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface[]
     */
    public function getBanners(): array;
}