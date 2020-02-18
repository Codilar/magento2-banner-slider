<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model;


use Codilar\BannerSlider\Api\Data\ResourceMapInterface;
use Magento\Framework\Model\AbstractModel;
use Codilar\BannerSlider\Model\ResourceModel\ResourceMap as ResourceModel;

class ResourceMap extends AbstractModel implements ResourceMapInterface
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'codilar_bannerslider_resource_map';

    /**
     * @var string
     */
    protected $_eventObject = 'resource_map';

    /**
     * @var string
     */
    protected $_cacheTag = 'codilar_bannerslider_resource_map';

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
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
     * @return ResourceMapInterface
     */
    public function setTitle(string $title): ResourceMapInterface
    {
        return $this->setData('title', $title);
    }

    /**
     * @return int|null
     */
    public function getMinWidth(): ?int
    {
        return $this->getData('min_width') ? (int)$this->getData('min_width') : null;
    }

    /**
     * @param int|null $minWidth
     * @return ResourceMapInterface
     */
    public function setMinWidth(?int $minWidth): ResourceMapInterface
    {
        return $this->setData('min_width', $minWidth);
    }

    /**
     * @return int
     */
    public function getMaxWidth(): ?int
    {
        return $this->getData('max_width') ? (int)$this->getData('max_width') : null;
    }

    /**
     * @param int|null $maxWidth
     * @return ResourceMapInterface
     */
    public function setMaxWidth(?int $maxWidth): ResourceMapInterface
    {
        return $this->setData('max_width', $maxWidth);
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
     * @return ResourceMapInterface
     */
    public function setCreatedAt(string $createdAt): ResourceMapInterface
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
     * @return ResourceMapInterface
     */
    public function setUpdatedAt(string $updatedAt): ResourceMapInterface
    {
        return $this->setData('updated_at', $updatedAt);
    }
}