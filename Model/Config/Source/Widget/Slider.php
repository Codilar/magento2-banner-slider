<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Config\Source\Widget;


class Slider extends \Codilar\BannerSlider\Model\Config\Source\Slider
{
    /**
     * @return \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected function getSearchCriteriaBuilder()
    {
        $searchCriteriaBuilder = parent::getSearchCriteriaBuilder();
        $searchCriteriaBuilder->addFilter('is_enabled', '1', 'eq');
        return $searchCriteriaBuilder;
    }
}