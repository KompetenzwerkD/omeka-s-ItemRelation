<?php 
namespace ItemRelation\Form;

use Laminas\Form\Form;

class ItemRelationForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'o:label',
            'type' => 'text',
            'options' => [
                'label' => 'Label',
                'info' => 'Name of the item relation',
            ],
            'attributes' => [
                'required' => true,
                'id' => 'o-label',
            ]
        ]);

        $this->add([
            'name' => 'o:parent_resource_template',
            'type' => 'Omeka\Form\Element\ResourceTemplateSelect',
            'options' => [
                'label' => 'Parent pesource template', // @translate
                'info' => 'Select parent resource template', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'chosen-select',
                'data-placeholder' => 'Select a resource template', // @translate
            ],
        ]);        

        $this->add([
            'name' => 'o:child_resource_template',
            'type' => 'Omeka\Form\Element\ResourceTemplateSelect',
            'options' => [
                'label' => 'Child resource template', // @translate
                'info' => 'Select child resource template', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'chosen-select',
                'data-placeholder' => 'Select a resource template', // @translate
            ],
        ]);   

        $this->add([
            'name' => 'o:connecting_property',
            'type' => 'Omeka\Form\Element\PropertySelect',
            'options' => [
                'label' => 'Connecting property', // @translate
                'info' => 'Select connecting property', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'chosen-select',
                'data-placeholder' => 'Select a property', // @translate
            ],
        ]);     
        
        $this->add([
            'name' => 'o:label_property',
            'type' => 'Omeka\Form\Element\PropertySelect',
            'options' => [
                'label' => 'Label property', // @translate
                'info' => 'Select label property', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'class' => 'chosen-select',
                'data-placeholder' => 'Select a property', // @translate
            ],
        ]);     
        
        
        $this->add([
            'name' => 'o:code_property',
            'type' => 'Omeka\Form\Element\PropertySelect',
            'options' => [
                'label' => 'Code property', // @translate
                'info' => 'Select code property', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'class' => 'chosen-select',
                'data-placeholder' => 'Select a property', // @translate
            ],
        ]);

        $this->add([
            'name' => 'o:code_template',
            'type' => 'text',
            'options' => [
                'label' => 'Code template',
                'info' => 'Define code template',
            ],
            'attributes' => [
                'required' => false,
                'id' => 'o-label',
            ]
        ]);        

    }
}