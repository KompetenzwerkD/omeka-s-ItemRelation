<?php declare(strict_types=1);
namespace ItemRelation;

use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;
use Laminas\EventManager\SharedEventManagerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Omeka\Module\AbstractModule;
use Omeka\Permissions\Assertion\OwnsEntityAssertion;


class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        parent::onBootstrap($event);

        $acl = $this->getServiceLocator()->get('Omeka\Acl');
        $acl->allow(
            null,
            \ItemRelation\Controller\IndexController::class,
            ['browse', 'show-details']
        );
        $acl->allow(
            null,
            \ItemRelation\Api\Adapter\ItemRelationAdapter::class,
            ['search', 'read']
        );
        $acl->allow(
            null,
            \ItemRelation\Entity\ItemRelation::class,
            ['read']
        );
        $acl->allow(
            'editor',
            \ItemRelation\Controller\IndexController::class,
            ['add', 'edit', 'delete']
        );
        $acl->allow(
            'editor',
            \ItemRelation\Api\Adapter\ItemRelationAdapter::class,
            ['create', 'update', 'delete']
        );
        $acl->allow(
            'editor',
            \ItemRelation\Entity\ItemRelation::class,
            'create'
        );
        $acl->allow(
            'editor',
            \ItemRelation\Entity\ItemRelation::class,
            ['update', 'delete'],
            new OwnsEntityAssertion
        );
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager): void 
    {
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.show.after',
            [$this, 'addRelatedItemsWidget']
        );
    }

    public function addRelatedItemsWidget($event) 
    {
        $view = $event->getTarget();

        $item = $event->getTarget()->vars()->resource;
        $itemRelations = $view->api()->search("item_relations")->getContent();
        foreach ($itemRelations as $itemRelation) {
            if ($item->resourceTemplate()) {
                $parentResourceTemplateId = $itemRelation->parentResourceTemplate()->id();
                if ($parentResourceTemplateId == $item->resourceTemplate()->id()) {
                    echo $view->relatedItemsWidget($itemRelation);
                }
            }                
        }
    }
    
    public function install(ServiceLocatorInterface $serviceLocator)
    {
        $conn = $serviceLocator->get('Omeka\Connection');
        $conn->exec('CREATE TABLE item_relation (id INT AUTO_INCREMENT NOT NULL, parent_resource_template_id INT DEFAULT NULL, child_resource_template_id INT DEFAULT NULL, connecting_property_id INT DEFAULT NULL, label_property_id INT DEFAULT NULL, label_item_set_id INT DEFAULT NULL, code_property_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, `label` VARCHAR(190) NOT NULL, code_template VARCHAR(190) DEFAULT NULL, show_form TINYINT(1) DEFAULT NULL, show_image TINYINT(1) DEFAULT NULL, layout VARCHAR(190) DEFAULT NULL, display_properties VARCHAR(190) DEFAULT NULL, UNIQUE INDEX UNIQ_E848F82EA750E8 (`label`), INDEX IDX_E848F82A5726818 (parent_resource_template_id), INDEX IDX_E848F825E8030D1 (child_resource_template_id), INDEX IDX_E848F826CD8148E (connecting_property_id), INDEX IDX_E848F82BF4EC31A (label_property_id), INDEX IDX_E848F827DDEA821 (label_item_set_id), INDEX IDX_E848F821DD3FA5C (code_property_id), INDEX IDX_E848F827E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F82A5726818 FOREIGN KEY (parent_resource_template_id) REFERENCES resource_template (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F825E8030D1 FOREIGN KEY (child_resource_template_id) REFERENCES resource_template (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F826CD8148E FOREIGN KEY (connecting_property_id) REFERENCES property (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F82BF4EC31A FOREIGN KEY (label_property_id) REFERENCES property (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F827DDEA821 FOREIGN KEY (label_item_set_id) REFERENCES item_set (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F821DD3FA5C FOREIGN KEY (code_property_id) REFERENCES property (id) ON DELETE SET NULL;');
        $conn->exec('ALTER TABLE item_relation ADD CONSTRAINT FK_E848F827E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE SET NULL;'); 
    }
    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $conn = $serviceLocator->get('Omeka\Connection');    
        $conn->exec('SET FOREIGN_KEY_CHECKS=0;');
        $conn->exec('DROP TABLE item_relation');
        $conn->exec('SET FOREIGN_KEY_CHECKS=1;');        
    }
}
?>