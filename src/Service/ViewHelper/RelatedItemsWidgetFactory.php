<?php declare(strict_types=1);
namespace ItemRelation\Service\ViewHelper;

use ItemRelation\View\Helper\RelatedItemsWidget;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RelatedItemsWidgetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $formElementManager = $services->get('FormElementManager');
        return new RelatedItemsWidget($formElementManager);
    }
}