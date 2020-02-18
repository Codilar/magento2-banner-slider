<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Resmap;


use Codilar\BannerSlider\Api\ResourceMapRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Codilar_BannerSlider::resource_map';
    /**
     * @var ResourceMapRepositoryInterface
     */
    private $resourceMapRepository;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param ResourceMapRepositoryInterface $resourceMapRepository
     */
    public function __construct(
        Action\Context $context,
        ResourceMapRepositoryInterface $resourceMapRepository
    )
    {
        parent::__construct($context);
        $this->resourceMapRepository = $resourceMapRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        try {
            /** @var Page $page */
            $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                $resourceMap = $this->resourceMapRepository->loadById($id);
                $page->getConfig()->getTitle()->set(__('Edit Resource Map "%1" (%2)', $resourceMap->getTitle(), $resourceMap->getEntityId()));
            } else {
                $page->getConfig()->getTitle()->set(__('Create New Resource Map'));
            }
            return $page;
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('The resource map you\'re looking for does not exist'));
            return $this->resultRedirectFactory->create()->setPath('*/*');
        }
    }
}