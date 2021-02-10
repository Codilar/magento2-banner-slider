<?php

namespace Codilar\BannerSlider\Model\Config\Source\Widget;

use Magento\Framework\Data\OptionSourceInterface;

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