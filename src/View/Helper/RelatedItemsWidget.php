<?php declare(strict_types=1);
namespace ItemRelation\View\Helper;

use ItemRelation\Entity\ItemRelation;
use ItemRelation\Api\Representation\ItemRelationRepresentation;
use ItemRelation\Form\AddRelatedItemForm;
use ItemRelation\Form\AddRelatedItemDropdownForm;
use Laminas\View\Helper\AbstractHelper;
use Omeka\Api\Representation\AbstractResourceEntityRepresentation;

class RelatedItemsWidget extends AbstractHelper
{
    protected $formElementManager;

    public function __construct($formElementManager) 
    {
        $this->formElementManager = $formElementManager;
    }

    public function __invoke(ItemRelationRepresentation $itemRelation) 
    {
        $view = $this->getView();
        
        if ($itemRelation->labelItemSet() != null) {
            $form = $this->formElementManager->get(AddRelatedItemDropdownForm::class);
            $form->setItemSetId($itemRelation->labelItemSet()->id());
            $form->init($itemRelation->labelItemSet()->id());
        }
        else
            $form = $this->formElementManager->get(AddRelatedItemForm::class);
        $form->get('o:parent_item')->setValue($view->resource->id());


        $rsp = $view->api()->search('items', [
            'resource_template_id' =>  $itemRelation->childResourceTemplate()->id(),
            'property' => [
                [
                    'joiner' => 'and',
                    'property' => $itemRelation->connectingProperty()->id(),
                    'text' => $view->resource->id(),
                    'type' => 'res',
                ],
            ],
            'sort_by' => $itemRelation->labelProperty()->term()
        ]);
        $relatedItems = $rsp->getContent();

        $view->vars()->offsetSet('addForm', $form);
        $view->vars()->offsetSet('itemRelation', $itemRelation);
        $view->vars()->offsetSet('relatedItems', $relatedItems);
        return $view->partial('common/related-item-widget');
    }
}