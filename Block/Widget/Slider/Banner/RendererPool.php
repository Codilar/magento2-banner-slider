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

class RendererPool
{
    /**
     * @var RendererInterface[]
     */
    private $renderers;

    /**
     * RendererPool constructor.
     * @param array $renderers
     */
    public function __construct(
        array $renderers = []
    )
    {
        $this->renderers = $renderers;
    }

    /**
     * @return RendererInterface[]
     */
    public function getRenderers(): array
    {
        return $this->renderers;
    }

    /**
     * @param BannerInterface $banner
     * @return RendererInterface|null
     */
    public function getRenderer(BannerInterface $banner): ?RendererInterface
    {
        $renderers = $this->getRenderers();
        foreach ($renderers as $resourceType => $renderer) {
            if ($banner->getResourceType() === $resourceType) {
                return $renderer;
            }
        }
        return null;
    }
}