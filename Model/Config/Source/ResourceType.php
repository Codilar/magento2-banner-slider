<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;

class ResourceType implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $resources;

    /**
     * ResourceType constructor.
     * @param array $resources
     */
    public function __construct(
        array $resources = []
    )
    {
        $this->resources = $resources;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->resources as $value => $label) {
            $result[] = [
                'label' => $label,
                'value' => $value
            ];
        }
        return $result;
    }
}