<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */
declare(strict_types=1);

namespace Codilar\BannerSlider\Model\Banner\ResourcePath;


use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;

interface ProcessorInterface
{
    /**
     * @param RequestInterface $request
     * @return string
     * @throws LocalizedException
     */
    public function process(RequestInterface $request): string;
}