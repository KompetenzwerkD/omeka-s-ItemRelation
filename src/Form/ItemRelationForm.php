<?php 
namespace ItemRelation\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Radio;

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
            'name' => 'o:label_item_set',
            'type' => 'Omeka\Form\Element\ItemSetSelect',
            'options' => [
                'label' => 'Label item set', // @translate
                'info' => 'Select label item set', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'required' => false,
                'class' => 'chosen-select',
                'data-placeholder' => 'Select an item set', // @translate
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

        $this->add([
            'name' => 'o:show_form',
            'type' => Radio::class,
            'options' => [
                'label' => 'Show form',
                'info' => 'Display add item form in widget',
                'value_options' => [
                    true  => 'yes',
                    false => 'no',
                ]
            ],
            'attributes' => [
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'o:show_image',
            'type' => Radio::class,
            'options' => [
                'label' => 'Show image',
                'info' => 'Display image from item media ',
                'value_options' => [
                    true  => 'yes',
                    false => 'no',
                ]                
            ],
            'attributes' => [
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'o:layout',
            'type' => Radio::class,
            'options' => [
                'label' => 'Widget layout',
                'info' => '',
                'value_options' => [
                    'list'  => 'list',
                    'box' => 'box',
                ]                
            ],
            'attributes' => [
                'required' => true,
            ]
        ]);        

        $this->add([
            'type' => 'textarea',
            'name' => 'o:display_properties' ,
            'options' => [
                'label' => 'Display properties',
                'info' => 'Enter property terms to show in widget (list layout).'
            ],
            'attributes' => [
                'required' => false
            ]
        ]);        

        $inputFilter = $this->getInputFilter();
        $inputFilter->add([
            'name' => 'o:label_item_set',
            'allow_empty' => true,
        ]);

    }
}