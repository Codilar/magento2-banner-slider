<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model;


use Codilar\BannerSlider\Api\Data\BannerInterface;
use Codilar\BannerSlider\Api\ResourceMapRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Codilar\BannerSlider\Model\ResourceModel\Banner as ResourceModel;

class Banner extends AbstractModel implements BannerInterface
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'codilar_bannerslider_banner';

    /**
     * @var string
     */
    protected $_eventObject = 'banner';

    /**
     * @var string
     */
    protected $_cacheTag = 'codilar_bannerslider_banner';

    /**
     * @var ResourceMapRepositoryInterface
     */
    private $resourceMapRepository;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ResourceMapRepositoryInterface $resourceMapRepository
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ResourceMapRepositoryInterface $resourceMapRepository,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
       parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->resourceMapRepository = $resourceMapRepository;
        $this->_init(ResourceModel::class);
    }

    /**
     * @return string
     */
    public function getSliderId(): int
    {
        return (int)$this->getData('slider_id');
    }

    /**
     * @param int $sliderId
     * @return BannerInterface
     */
    public function setSliderId(int $sliderId): BannerInterface
    {
        return $this->setData('slider_id', $sliderId);
    }

    /**
     * @return int
     */
    public function getResourceMapId(): int
    {
        return $this->getData('resource_map_id');
    }

    /**
     * @param int $resourceMapId
     * @return BannerInterface
     */
    public function setResourceMapId(int $resourceMapId): BannerInterface
    {
        return $this->setData('resource_map_id', $resourceMapId);
    }

    /**
     * @return string|null
     */
    public function getResourceType(): ?string
    {
        return $this->getData('resource_type');
    }

    /**
     * @param string|null $resourceType
     * @return BannerInterface
     */
    public function setResourceType(?string $resourceType): BannerInterface
    {
        return $this->setData('resource_type', $resourceType);
    }

    /**
     * @return string|null
     */
    public function getResourcePath(): ?string
    {
        return $this->getData('resource_path');
    }

    /**
     * @param string|null $resourcePath
     * @return BannerInterface
     */
    public function setResourcePath(?string $resourcePath): BannerInterface
    {
        return $this->setData('resource_path', $resourcePath);
    }

    /**
     * @return int
     */
    public function getIsEnabled(): int
    {
        return (int)$this->getData('is_enabled');
    }

    /**
     * @param int $isEnabled
     * @return BannerInterface
     */
    public function setIsEnabled(int $isEnabled): BannerInterface
    {
        return $this->setData('is_enabled', $isEnabled);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData('created_at');
    }

    /**
     * @param string $createdAt
     * @return BannerInterface
     */
    public function setCreatedAt(string $createdAt): BannerInterface
    {
        return $this->setData('created_at', $createdAt);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData('updated_at');
    }

    /**
     * @param string $updatedAt
     * @return BannerInterface
     */
    public function setUpdatedAt(string $updatedAt): BannerInterface
    {
        return $this->setData('updated_at', $updatedAt);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData('title');
    }

    /**
     * @param string $title
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setTitle(string $title): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        return $this->setData('title', $title);
    }

    /**
     * @return string
     */
    public function getAltText(): string
    {
        return $this->getData('alt_text');
    }

    /**
     * @param string $altText
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setAltText(string $altText): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        return $this->setData('alt_text', $altText);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->getData('link');
    }

    /**
     * @param string $link
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setLink(string $link): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        return $this->setData('link', $link);
    }

    /**
     * @return int
     */
    public function getSortOrder(): int
    {
        return (int)$this->getData('sort_order');
    }

    /**
     * @param int $sortOrder
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function setSortOrder(int $sortOrder): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        return $this->setData('sort_order', $sortOrder);
    }

    /**
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface|null
     */
    public function getResourceMap(): ?\Codilar\BannerSlider\Api\Data\ResourceMapInterface
    {
        try {
            return $this->resourceMapRepository->loadById($this->getResourceMapId());
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}