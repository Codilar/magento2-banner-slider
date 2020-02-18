<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Slider;


use Codilar\BannerSlider\Api\Data\SliderInterface;
use Magento\Framework\Exception\CouldNotDeleteException;

class MassDelete extends AbstractMassAction
{
    /**
     * @param \Codilar\BannerSlider\Model\ResourceModel\Slider\Collection $collection
     * @return void
     */
    protected function processCollection(\Codilar\BannerSlider\Model\ResourceModel\Slider\Collection $collection): void
    {
        $itemsDeleted = 0;
        /** @var SliderInterface $item */
        foreach ($collection as $item) {
            try {
                $this->sliderRepository->delete($item);
                $itemsDeleted++;
            } catch (CouldNotDeleteException $e) {
                $this->messageManager->addErrorMessage(__('Error Deleting %1: %2', $item->getEntityId(), $e->getMessage()));
            }
        }
        $this->messageManager->addSuccessMessage(__('%1 Slider(s) deleted', $itemsDeleted));
    }
}