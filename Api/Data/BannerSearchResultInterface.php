<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Api\Data;


interface BannerSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}