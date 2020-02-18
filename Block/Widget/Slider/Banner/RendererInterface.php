<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Block\Widget\Slider\Banner;


use Codilar\BannerSlider\Api\Data\BannerInterface;

interface RendererInterface
{
    /**
     * @param BannerInterface $banner
     * @param string $widgetClassName
     * @return string
     */
    public function render(BannerInterface $banner, string $widgetClassName): string;
}