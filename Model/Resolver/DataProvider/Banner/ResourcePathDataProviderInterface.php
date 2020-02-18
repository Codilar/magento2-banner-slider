<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Resolver\DataProvider\Banner;


use Codilar\BannerSlider\Api\Data\BannerInterface;

interface ResourcePathDataProviderInterface
{
    /**
     * @param BannerInterface $banner
     * @return string
     */
    public function resolve(BannerInterface $banner);
}