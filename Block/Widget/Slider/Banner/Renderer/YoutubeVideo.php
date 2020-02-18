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

class YoutubeVideo extends AbstractRenderer
{
    protected $_template = 'Codilar_BannerSlider::widget/banner/renderer/youtube_video.phtml';
}