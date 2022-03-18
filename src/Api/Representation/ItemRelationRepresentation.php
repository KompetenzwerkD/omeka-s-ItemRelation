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
        $labelItemSet = null;
        $codeProperty = null;
        $owner = null;
        $props = null;
        $propsArray=[];

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
        if($this->labelItemSet()) {
            $labelItemSet = $this->labelItemSet()->getReference();
        }
        if ($this->codeProperty()) {
            $codeProperty = $this->codeProperty()->getReference();
        }
        
        if ($this->owner())
        {
            $owner = $this->owner()->getReference();
        }

        if ($this->displayProperties()) {
            $props = $this->displayProperties();
            $props = nl2br($props);
            $propsArray = explode('<br />', $props);
            $propsArray = array_map('trim', $propsArray);
        }

        return [
            'o:label' => $this->label(),
            'o:parent_resource_template' => $parentResourceTemplate,
            'o:child_resource_template' => $childResourceTemplate,
            'o:connecting_property' => $connectingProperty,
            'o:label_property' => $labelProperty,
            'o:label_item_set' => $labelItemSet,
            'o:code_property' => $codeProperty,
            'o:code_template' => $this->codeTemplate(),
            'o:owner' => $owner,
            'o:show_form' => $this->showForm(),
            'o:show_image' => $this->showImage(),
            'o:layout' => $this->layout(),
            'o:display_properties' => $propsArray,
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

    public function labelItemSet()
    {
        return $this->getAdapter('item_sets')
            ->getRepresentation($this->resource->getLabelItemSet());
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

    public function showForm() 
    {
        return $this->resource->getShowForm();
    }
    
    public function showImage()
    {
        return $this->resource->getShowImage();
    }

    public function layout() 
    {
        return $this->resource->getLayout();
    }

    public function displayProperties()
    {
        return $this->resource->getDisplayProperties();
    }
}