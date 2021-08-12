<?php
namespace ItemRelation\Api\Representation;

use Omeka\Api\Representation\AbstractEntityRepresentation;

class ItemRelationRepresentation extends AbstractEntityRepresentation
{
    public function getControllerName()
    {
        return 'item-relation';
    }

    public function getJsonLdType()
    {
        return 'o:ItemRelation';
    }

    public function getJsonLd()
    {
        $parentResourceTemplate = null;
        $childResourceTemplate = null;
        $connectingProperty = null;
        $labelProperty = null;
        $codeProperty = null;
        $owner = null;

        if ($this->parentResourceTemplate()) {
            $parentResourceTemplate = $this->parentResourceTemplate()->getReference();
        }
        if ($this->childResourceTemplate()) {
            $childResourceTemplate = $this->childResourceTemplate()->getReference();
        }
        if ($this->connectingProperty()) {
            $connectingProperty = $this->connectingProperty()->getReference();
        }
        if ($this->labelProperty()) {
            $labelProperty = $this->labelProperty()->getReference();
        }
        if ($this->codeProperty()) {
            $codeProperty = $this->codeProperty()->getReference();
        }
        
        if ($this->owner())
        {
            $owner = $this->owner()->getReference();
        }
        return [
            'o:label' => $this->label(),
            'o:parent_resource_template' => $parentResourceTemplate,
            'o:child_resource_template' => $childResourceTemplate,
            'o:connecting_property' => $connectingProperty,
            'o:label_property' => $labelProperty,
            'o:code_property' => $codeProperty,
            'o:code_template' => $this->codeTemplate(),
            'o:owner' => $owner
        ];
    }

    public function label() 
    {
        return $this->resource->getLabel();
    }

    public function codeTemplate()
    {
        return $this->resource->getCodeTemplate();
    }

    public function parentResourceTemplate()
    {
        return $this->getAdapter('resource_templates')
            ->getRepresentation($this->resource->getParentResourceTemplate());
    }

    public function childResourceTemplate()
    {
        return $this->getAdapter('resource_templates')
            ->getRepresentation($this->resource->getChildResourceTemplate());
    }

    public function connectingProperty() 
    {
        return $this->getAdapter('properties')
            ->getRepresentation($this->resource->getConnectingProperty());
    }

    public function labelProperty()
    {
        return $this->getAdapter('properties')
            ->getRepresentation($this->resource->getLabelProperty());
    }

    public function codeProperty()
    {
        return $this->getAdapter('properties')
            ->getRepresentation($this-> resource->getCodeProperty());
    }

    public function owner()
    {
        return $this->getAdapter('users')
            ->getRepresentation($this->resource->getOwner());
    }    
}