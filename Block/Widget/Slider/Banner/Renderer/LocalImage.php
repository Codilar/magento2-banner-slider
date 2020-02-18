<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Block\Widget\Slider\Banner\Renderer;


use Codilar\BannerSlider\Api\Data\BannerInterface;
use Codilar\BannerSlider\Block\Widget\Slider\Banner\RendererInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class LocalImage extends AbstractRenderer
{

    protected $_template = 'Codilar_BannerSlider::widget/banner/renderer/local_image.phtml';

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        /** @var \Magento\Store\Model\Store $store */
        try {
            $store = $this->_storeManager->getStore();
            return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        } catch (NoSuchEntityException $e) {
            return '';
        }
    }
}