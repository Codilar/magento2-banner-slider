<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Banner;

use Codilar\BannerSlider\Api\BannerRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

abstract class AbstractMassAction extends Action
{
    const ADMIN_RESOURCE = 'Codilar_BannerSlider::banner';

    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * AbstractMassAction constructor.
     * @param Action\Context $context
     * @param BannerRepositoryInterface $bannerRepository
     * @param Filter $filter
     */
    public function __construct(
        Action\Context $context,
        BannerRepositoryInterface $bannerRepository,
        Filter $filter
    )
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->bannerRepository = $bannerRepository;
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
        $collection = $this->bannerRepository->getCollection();
        try {
            $this->filter->getCollection($collection);
            $this->processCollection($collection);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('*/*');
    }

    /**
     * @param \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection $collection
     * @return void
     */
    abstract protected function processCollection(\Codilar\BannerSlider\Model\ResourceModel\Banner\Collection $collection): void;
}