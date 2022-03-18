<?php
namespace ItemRelation\Api\Adapter;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Request;
use Omeka\Entity\EntityInterface;
use Omeka\Stdlib\ErrorStore;

class ItemRelationAdapter extends AbstractEntityAdapter
{
    public function getResourceName()
    {
        return 'item_relation';
    }

    public function getRepresentationClass() 
    {
        return \ItemRelation\Api\Representation\ItemRelationRepresentation::class;
    }

    public function getEntityClass()
    {
        return \ItemRelation\Entity\ItemRelation::class;
    }

    protected function getValue($request, $resource, $elem) 
    {
        $value = $request->getValue($elem);
        if ($value && isset($value['o:id'])) 
        {
            return  $this->getAdapter($resource)->findEntity($value['o:id']);
        }
        else 
        {
            return null;
        }
    }

    public function hydrate(
        Request $request,
        EntityInterface $entity,
        ErrorStore $errorStore
    ) {
        $this->hydrateOwner($request, $entity);
        if ($this->shouldHydrate($request, 'o:label')) 
        {
            $entity->setLabel($request->getValue('o:label'));
        }
        if ($this->shouldHydrate($request, 'o:code_template'))
        {
            $entity->setCodeTemplate($request->getValue('o:code_template'));
        }
        if ($this->shouldHydrate($request, 'o:parent_resource_template'))
        {
            $resourceTemplate = $this->getValue($request, 'resource_templates', 'o:parent_resource_template');
            $entity->setParentResourceTemplate($resourceTemplate);
        }
        if ($this->shouldHydrate($request, 'o:child_resource_template'))
        {
            $resourceTemplate = $this->getValue($request, 'resource_templates', 'o:child_resource_template');
            $entity->setChildResourceTemplate($resourceTemplate);
        }
        if ($this->shouldHydrate($request, 'o:connecting_property'))
        {
            $prop = $this->getValue($request, 'properties', 'o:connecting_property');
            $entity->setConnectingProperty($prop);
        }        
        if ($this->shouldHydrate($request, 'o:label_property')) 
        {
            $prop = $this->getValue($request, 'properties', 'o:label_property');
            $entity->setLabelProperty($prop);
        }
        if ($this->shouldHydrate($request, 'o:label_item_set')) 
        {
            $itemSet = $this->getValue($request, 'item_sets', 'o:label_item_set');
            $entity->setLabelItemSet($itemSet);
        }        
        if ($this->shouldHydrate($request, 'o:code_property'))
        {
            $prop = $this->getValue($request, 'properties', 'o:code_property');
            $entity->setCodeProperty($prop);
        }

        if ($this->shouldHydrate($request, 'o:show_form'))
        {
            $entity->setShowForm($request->getValue('o:show_form'));
        }
        if ($this->shouldHydrate($request, 'o:show_image'))
        {
            $entity->setShowImage($request->getValue('o:show_image'));
        }
        if ($this->shouldHydrate($request, 'o:layout'))
        {
            $entity->setLayout($request->getValue('o:layout'));
        }

        if ($this->shouldHydrate($request, 'o:display_properties')) {
            $entity->setDisplayProperties($request->getValue('o:display_properties'));
        }
        
    }


    protected function addCannotBeEmptyError($elem, $value, $errorStore) {
        if (trim($value) == false) {
            $errorStore->addError($elem, 'Cannot be empty.');
        }
    }

    public function validateEntity(
        EntityInterface $entity, 
        ErrorStore $errorStore
    ) {
        $this->addCannotBeEmptyError('o:label', $entity->getLabel(), $errorStore);
        if ($entity->getParentResourceTemplate() == null) {
            $errorStore->addError('o:parent-resource-template', 'Cannot be empty');
        }
    }
}
