<?php
namespace ItemRelation\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Hidden;

class AddRelatedItemForm extends Form 
{
    public function init()
    {
        $this->add([
            'name' => 'o:title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
                'info' => 'Title of new related item',
            ]
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
                'value' => 'text'
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