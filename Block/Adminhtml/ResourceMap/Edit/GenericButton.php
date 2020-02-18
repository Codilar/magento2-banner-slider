<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Block\Adminhtml\ResourceMap\Edit;


use Codilar\BannerSlider\Api\ResourceMapRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

abstract class GenericButton implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var ResourceMapRepositoryInterface
     */
    private $resourceMapRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param ResourceMapRepositoryInterface $resourceMapRepository
     */
    public function __construct(
        Context $context,
        ResourceMapRepositoryInterface $resourceMapRepository
    )
    {
        $this->context = $context;
        $this->resourceMapRepository = $resourceMapRepository;
    }

    /**
     * @return int|null
     */
    protected function getResourceMapId()
    {
        try {
            return $this->resourceMapRepository->loadById((int)$this->context->getRequest()->getParam('entity_id'))->getEntityId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    protected function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}