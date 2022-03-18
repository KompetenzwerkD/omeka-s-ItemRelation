<?php
namespace ItemRelation\Entity;

use Omeka\Entity\AbstractEntity;
use Omeka\Entity\ItemSet;
use Omeka\Entity\User;

/**
 * @Entity
 */
class ItemRelation extends AbstractEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(unique=true, length=190)
     */
    protected $label;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\ResourceTemplate")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $parentResourceTemplate;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\ResourceTemplate")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $childResourceTemplate;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\Property")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $connectingProperty;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\Property")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $labelProperty;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\ItemSet")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $labelItemSet;

    /**
     * @ManyToOne(targetEntity="Omeka\Entity\Property")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $codeProperty;

    /**
     * @Column(length=190, nullable=true)
     */
    protected $codeTemplate;

    /**
     * @Column(type="boolean",  nullable=true)
     */
    protected $showForm;

    /**
     * @Column(type="boolean",  nullable=true)
     */
    protected $showImage;    

    /**
     * @Column(length=190, nullable=true)
     */
    protected $layout;    


    /**
     * @Column(length=190, nullable=true)
     */
    protected $displayProperties;    
    
    /**
     * @ManyToOne(targetEntity="Omeka\Entity\User")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $owner;    

    public function getId()
    {
        return $this->id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setOwner($owner = null)
    {
        $this->owner = $owner;
    }

    public function getOwner() 
    {
        return $this->owner;
    }

    public function getConnectingProperty()
    {
        return $this->connectingProperty;
    }

    public function setConnectingProperty($prop = null)
    {
        $this->connectingProperty = $prop;
    }

    public function getLabelProperty()
    {
        return $this->labelProperty;
    }

    public function setLabelProperty($prop = null)
    {
        $this->labelProperty = $prop;
    }

    public function getLabelItemSet() 
    {
        return $this->labelItemSet;
    }

    public function setLabelItemSet(ItemSet $itemSet = null)
    {
        $this->labelItemSet = $itemSet;
    }

    public function getCodeProperty()
    {
        return $this->codeProperty;
    }

    public function setCodeProperty($prop = null)
    {
        $this->codeProperty = $prop;
    }

    public function getParentResourceTemplate()
    {
        return $this->parentResourceTemplate;
    }

    public function setParentResourceTemplate($resourceTemplate = null)
    {
        $this->parentResourceTemplate = $resourceTemplate;
    }

    public function getChildResourceTemplate()
    {
        return $this->childResourceTemplate;
    }

    public function setChildResourceTemplate($resourceTemplate = null)
    {
        $this->childResourceTemplate = $resourceTemplate;
    }

    public function getCodeTemplate()
    {
        return $this->codeTemplate;
    }

    public function setCodeTemplate($template)
    {
        $this->codeTemplate = $template;
    }

    public function getShowForm() {
        return $this->showForm;
    }

    public function setShowForm($showForm = true) {
        $this->showForm = $showForm;
    }

    public function getShowImage() {
        return $this->showImage;
    }

    public function setShowImage($showImage = true) {
        $this->showImage = $showImage;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout = null) {
        $this->layout = $layout;
    }

    public function getDisplayProperties() {
        return $this->displayProperties;
    }

    public function setDisplayProperties($displayProperties = null) {
        $this->displayProperties = $displayProperties;
    }
}
