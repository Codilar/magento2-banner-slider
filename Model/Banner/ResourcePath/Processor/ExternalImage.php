<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Banner\ResourcePath\Processor;


use Codilar\BannerSlider\Model\Banner\ResourcePath\ProcessorInterface;
use Magento\Framework\App\RequestInterface;

class ExternalImage implements ProcessorInterface
{

    /**
     * @param RequestInterface $request
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function process(RequestInterface $request): string
    {
        return $request->getParam('resource_path_external_image');
    }
}