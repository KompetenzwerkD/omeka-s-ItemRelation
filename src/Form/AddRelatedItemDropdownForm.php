<?php
namespace ItemRelation\Form;

use Omeka\Form\Element\ResourceSelect;
use Laminas\Form\Form;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Hidden;

class AddRelatedItemDropdownForm extends Form 
{
    protected $itemSetId;

    /*public function __construct($itemSetId, $name = null, $options = []) {
        parent::__construct($name, $options);
        $this->itemSetId = $itemSetId;
    }*/

    public function setItemSetId($id) {
        $this->itemSetId = $id;
    }

    public function getItemSetId()
    {
        return $this->itemSetId;
    }

    public function init()
    {

        $this->add([
            'name' => 'o:title',
            'type' => ResourceSelect::class,
            'options' => [
                'label' => 'Related item', 
                'info' => 'Select item', 
                'empty_option' => '', 
                'resource_value_options' => [
                    'resource' => 'items',
                    'query' => [ 'item_set_id' => $this->getItemSetId(), 'sort_by' => 'title'],
                    'option_text_callback' => function ($item) {
                        return $item->displayTitle();
                    },                    
                ],                
            ],
            'attributes' => [
                'required' => true,
                'class' => 'chosen-select',
                'data-placeholder' => 'Select item'
            ],
        ]);        

        $this->add([
            'name' => 'o:parent_item',
            'type' => Hidden::class,
            'attributes' => [
                'value' => ''
            ]
        ]);

        $this->add([
            'name' => 'o:type',
            'type' => Hidden::class,
            'attributes' => [
                'value' => 'dropdown'
            ]
        ]);


        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Add'
            ]
            ]);
    }
}