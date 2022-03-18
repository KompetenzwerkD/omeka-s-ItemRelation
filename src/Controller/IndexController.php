<?php
namespace ItemRelation\Controller;

use ItemRelation\Form\AddRelatedItemForm;
use ItemRelation\Form\ItemRelationForm;
use Omeka\Form\ConfirmForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController 
{


    public function indexAction() 
    {
        $ItemRelations = $this->api()->search('item_relations')->getContent();

        $view = new ViewModel;
        $view = $view->setVariable('itemRelations', $ItemRelations);
        return $view;
    }

    public function addAction()
    {
        $form = $this->getForm(ItemRelationForm::class);

        if ($this->getRequest()->isPost()) 
        {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $formData = $form->getData();

                $formData['o:parent_resource_template'] = ['o:id' => $formData['o:parent_resource_template']];
                $formData['o:child_resource_template'] = ['o:id' => $formData['o:child_resource_template']];
                $formData['o:connecting_property'] = ['o:id' => $formData['o:connecting_property']];
                $formData['o:label_property'] = ['o:id' => $formData['o:label_property']];
                $formData['o:label_item_set'] = $formData['o:label_item_set'] ? ['o:id' => $formData['o:label_item_set']] : null;
                $formData['o:code_property'] = ['o:id' => $formData['o:code_property']];

                $response = $this->api($form)->create('item_relations', $formData);
                if ($response) {
                    $this->messenger()->addSuccess('ItemRelation created.'); // @translate
                    $this->redirect()->toRoute('admin/item-relation');
                }
            }
        }

        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }


    public function deleteConfirmAction()
    {
        $form = $this->getForm(ConfirmForm::class);
        $id = $this->params()->fromRoute('id');
        $resource = $this->api()->read('item_relations', $id)->getContent();
        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setVariable('form', $form);
        $view->setVariable('resource', $resource);
        return $view;
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if ($this->getRequest()->isPost()) {
            $rsp = $this->api()->delete('item_relations', $id);
            if ($rsp) {
                $this->messenger()->addSuccess('Sub item sucessfully deleted');
            } else {
                $this->messenger()->addError('Sub item could not be deleted');
            }
        }
        return $this->redirect()->toRoute('admin/item-relation');
    }

    public function editAction()
    {
        $form = $this->getForm(ItemRelationForm::class);
        $rsp = $this->api()->read('item_relations', $this->params('id'));
        $itemRelation = $rsp->getContent();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $data['o:parent_resource_template'] = ['o:id' => $data['o:parent_resource_template']];
            $data['o:child_resource_template'] = ['o:id' => $data['o:child_resource_template']];
            $data['o:connecting_property'] = ['o:id' => $data['o:connecting_property']];
            $data['o:label_property'] = ['o:id' => $data['o:label_property']];
            $data['o:label_item_set'] = $data['o:label_item_set'] ? ['o:id' => $data['o:label_item_set']] : null;
            $data['o:code_property'] = ['o:id' => $data['o:code_property']];
            $rsp = $this->api()->update('item_relations', $itemRelation->id(), $data);
            if ($rsp) {
                $this->messenger()->addSuccess('Item relation updated.');
                return $this->redirect()->toRoute('admin/item-relation');
            }
            else {
                $this->messenger()->addError('Error during updating sub item');
            }

        } else {
            $data = $itemRelation->jsonSerialize();
            $data['o:parent_resource_template'] = $data['o:parent_resource_template'] ? $data['o:parent_resource_template']->id() : null;
            $data['o:child_resource_template'] = $data['o:child_resource_template'] ? $data['o:child_resource_template']->id() : null;
            $data['o:connecting_property'] = $data['o:connecting_property'] ? $data['o:connecting_property']->id() : null;
            $data['o:label_property'] = $data['o:label_property'] ? $data['o:label_property']->id() : null;
            $data['o:label_item_set'] = $data['o:label_item_set'] ? $data['o:label_item_set']->id() : null;
            $data['o:code_property'] = $data['o:code_property'] ? $data['o:code_property']->id() : null;

            $data['o:display_properties'] = $itemRelation->displayProperties();
            $form->setData($data);
        }

        $view = new ViewModel;
        $view->setVariable('form', $form);
        $view->setVariable('itemRelation', $itemRelation);
        return $view;
    }

    public function addItemAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $id = $this->params()->fromRoute('id');

            $relation = $this->api()->read('item_relations', $id)->getContent();
            $parentItem = $this->api()->read('items', $data['o:parent_item'])->getContent();
            $type = $data['o:type'];

            $resourceClass = $relation->childResourceTemplate()->resourceClass();
            $labelProperty = $relation->labelProperty();
            $connectingProperty = $relation->connectingProperty();
            $codeProperty = $relation->codeProperty();

            $code = $relation->codeTemplate();
            if (strpos($code, '<count>') !== null) {
                $count = $this->api()->search('items', [ 'resource_template_id' => $relation->childResourceTemplate()->id() ])->getTotalResults();
                $code = str_replace('<count>', sprintf('%04d', $count + 1), $code);
            }
            if (strpos($code, '<parent>') !== null) {
                $parent = $parentItem->value($relation->codeProperty()->term());
                if (!$parent) {
                    $parent = $parentItem->displayTitle();
                }
                if ($parent) {
                    $code = str_replace('<parent>', $parent, $code);
                }
            }
            if (strpos($code, '<title>') !== null) {
                $code = str_replace('<title>', $data['o:title'], $code);
            }


            $item = [
                'o:resource_template' => [ 
                    'o:id' => $relation->childResourceTemplate()->id(), 
                ],
                'o:resource_class' => [
                    'o:id' => $resourceClass->id(),
                ],
                $labelProperty->term() => [
                    [
                        'type' => 'literal',
                        'property_id' => $labelProperty->id(),
                        '@value' => $data['o:title'],
                    ],
                ],
                $connectingProperty->term() => [
                    [
                        'type' => 'resource:item',
                        'property_id' => $connectingProperty->id(),
                        'value_resource_id' => $parentItem->id(),
                    ],
                ],    
                $codeProperty->term() => [
                    [
                        'type' => 'literal',
                        'property_id' => $codeProperty->id(),
                        '@value' => $code,
                    ],
                ],                    
            ];

            if ($type == "text") {
                $item[$labelProperty->term()] = [
                    [
                        'type' => 'literal',
                        'property_id' => $labelProperty->id(),
                        '@value' => $data['o:title'],
                    ],
                ];
            } else {
                $item[$labelProperty->term()] = [
                    [
                        'type' => 'resource:item',
                        'property_id' => $labelProperty->id(),
                        'value_resource_id' => $data['o:title'],
                    ],
                ];                
            }

            $newItem = $this->api()->create('items', $item);

            $form = $this->getForm(AddRelatedItemForm::class);
            return $this->redirect()->toUrl($parentItem->url());
        }

        return $this->redirect()->toRoute('admin/item-relation');
    }

    public function deleteItemAction() {
        $parentId = $this->params()->fromRoute('parent');
        $childId = $this->params()->fromRoute('child');

        $parentItem = $this->api()->read('items', $parentId)->getContent();
        $response = $this->api()->delete('items', $childId);

        if ($response) {
            $this->messenger()->addSuccess('Item deleted.');
        }

        return $this->redirect()->toUrl($parentItem->url());

    }

}