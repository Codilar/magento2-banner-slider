<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Resolver\DataProvider\Banner;


use Codilar\BannerSlider\Api\Data\BannerInterface;

class ResourcePath implements ResourcePathDataProviderInterface
{
    /**
     * @var ResourcePathDataProviderInterface[]
     */
    private $resolvers;

    /**
     * ResourcePath constructor.
     * @param array $resolvers
     */
    public function __construct(
        array $resolvers = []
    )
    {
        $this->resolvers = $resolvers;
    }

    /**
     * @param BannerInterface $banner
     * @return string
     */
    public function resolve(BannerInterface $banner)
    {
        if (isset($this->resolvers[$banner->getResourceType()])) {
            return $this->resolvers[$banner->getResourceType()]->resolve($banner);
        } else {
            return $banner->getResourcePath();
        }
    }
}