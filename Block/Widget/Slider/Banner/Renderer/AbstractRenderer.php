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
use Magento\Framework\View\Element\Template;

class AbstractRenderer extends Template implements RendererInterface
{

    /**
     * @var BannerInterface
     */
    private $banner;

    private $widgetClassName;

    /**
     * @return BannerInterface|null
     */
    public function getBanner(): ?BannerInterface
    {
        return $this->banner;
    }

    /**
     * @return null|string
     */
    public function getWidgetClassName(): ?string
    {
        return $this->widgetClassName;
    }

    /**
     * @param BannerInterface $banner
     * @param string $widgetClassName
     * @return string
     */
    public function render(BannerInterface $banner, string $widgetClassName): string
    {
        $this->banner = $banner;
        $this->widgetClassName = $widgetClassName;
        return $this->toHtml();
    }
}