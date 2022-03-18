<?php
namespace ItemRelation\Service\Form;

use ItemRelation\Form\AddRelatedItemDropdownForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AddRelatedItemDropdownFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $form = new AddRelatedItemDropdownForm(null, $options);
        $config = $services->get('Config');
        $form->setConfigCsvImport($config['csv_import']);
        $form->setUserSettings($services->get('Omeka\Settings\User'));
        return $form;
    }
}
