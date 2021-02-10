<?php

namespace Codilar\BannerSlider\Model\Config\Source\Widget;

use Magento\Framework\Data\OptionSourceInterface;
/**
 *
 * @module Codilar_BannerSlider
 * @description Modification for PWA
 * @author    <ankith@codilar.com>
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Pvt. Ltd.. All rights reserved
 *
 * Modification for Mageplaza Shop by brand
 */
class BannerSources implements OptionSourceInterface
{

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'both', 'label' => __('Both')],
            ['value' => 'desktop_only', 'label' => __('Desktop')],
            ['value' => 'mobile_only', 'label' => __('Mobile')],
            ['value' => 'no', 'label' => __('No')]
        ];
    }
}