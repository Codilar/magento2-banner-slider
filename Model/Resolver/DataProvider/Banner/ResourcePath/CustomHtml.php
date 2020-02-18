<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Resolver\DataProvider\Banner\ResourcePath;


use Codilar\BannerSlider\Api\Data\BannerInterface;
use Codilar\BannerSlider\Model\Resolver\DataProvider\Banner\ResourcePathDataProviderInterface;
use Magento\Widget\Model\Template\FilterEmulate;

class CustomHtml implements ResourcePathDataProviderInterface
{
    /**
     * @var FilterEmulate
     */
    private $filterEmulate;

    /**
     * CustomHtml constructor.
     * @param FilterEmulate $filterEmulate
     */
    public function __construct(
        FilterEmulate $filterEmulate
    )
    {
        $this->filterEmulate = $filterEmulate;
    }

    /**
     * @param BannerInterface $banner
     * @return string
     */
    public function resolve(BannerInterface $banner)
    {
        return $this->filterEmulate->filter($banner->getResourcePath());
    }
}