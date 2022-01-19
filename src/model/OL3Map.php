<?php

namespace App\OL3\model;


use App\OL3\model\layers\OL3Layer;
use GridFieldSortableRows;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;


/**
 * File contains the OL3Map class.
 *
 * @author Catalyst SilverStripe Team <silverstripedev@catalyst.net.nz>
 * @package openlayers3
 */

/**
 * Representation of an Openlayers3 ol.View
 * @link http://openlayers.org/en/v3.19.1/apidoc/ol.View.html
 */
class OL3Map extends DataObject
{
    /**
     * Nice singular name for this class to be used in the CMS.
     *
     * @var string
     */
    private static $singular_name = 'Map';

    /**
     * Nice plural name for this class to be used in the CMS.
     *
     * @var string
     */
    private static $plural_name = 'Maps';

    /**
     * Map of class properties to persist in the database.
     * Keys are property names, values are data types.
     *
     * @var array
     */
    private static $db = [
        'Title'      => 'Varchar',
        'Projection' => 'Varchar',
        'Lat'        => 'Decimal(12,6)',
        'Lon'        => 'Decimal(12,6)',
        'MinLat'     => 'Decimal(12,6)',
        'MinLon'     => 'Decimal(12,6)',
        'MaxLat'     => 'Decimal(12,6)',
        'MaxLon'     => 'Decimal(12,6)',
        'Zoom'       => 'Int',
        'MinZoom'    => 'Int',
        'MaxZoom'    => 'Int',
    ];

    /**
     * Specifying Field names where they differ from their property names.
     * Keys are property names, values are nice field names.
     *
     * @var array Nice column names
     */
    private static $field_labels = [
        'Lat' => 'Latitude',
        'Lon' => 'Longitude',
    ];

    /**
     * Used by the ORM to establish class relations.
     * Map of has_one components.
     * Keys are component names, values are DataObject class names.
     *
     * @var array has_one component classes
     */
    private static $has_one = [
        'Background' => OL3Layer::class,
    ];

    /**
     * Used by the ORM to establish class relations.
     * Map of has_one components.
     * Keys are component names, values are DataObject class names.
     *
     * @var array has_many component classes
     */
    private static $has_many = [
        'Layers' => OL3Layer::class,
    ];

    /**
     * Map of default values to hydrate instances with on creation.
     * Keys are property names, values are scalar values.
     *
     * @var array
     */
    private static $defaults = [
        'Zoom'    => 8,
        'MinZoom' => 1,
        'MaxZoom' => 30,
    ];

    /**
     * Getter for the template to retrive the ol.layer config for all layers to be displayed
     * @return string JSON representation of $this->Layers()
     */
    public function JsonLayers()
    {
        return json_encode($this->Layers()->toNestedArray());
    }

    /**
     * Getter for the template to retrive the ol.style config for all styles attached
     * to all layers of the map.
     *
     * @return string A JSON array of all styles necessary to display all vector layers.
     * @see OL3Style::getStyles()
     */
    public function JsonStyles()
    {
        $styles = [];
        foreach ($this->Layers() as $layer) {
            if ($layer->hasMethod('getStyles')) {
                $layer->getStyles($styles);
            }
        }

        return json_encode($styles);
    }

    /**
     * Getter for the template to retrive the ol.View config object
     *
     * @return string JSON representation of $this->toMap()
     */
    public function JsonView()
    {
        return json_encode($this->toMap());
    }

    /**
     * @return string **V** of MVC for OL3Map
     */
    public function forTemplate()
    {
        $this->requirements();

        return $this->renderWith(__CLASS__);
    }

    public static function requirements()
    {
        Requirements::css('openlayers3/thirdparty/ol.css');
        Requirements::javascript('openlayers3/thirdparty/promise.js');
        Requirements::javascript('openlayers3/thirdparty/fetch.js');
        Requirements::javascript('openlayers3/thirdparty/CustomEvent.js');
        Requirements::javascript('openlayers3/thirdparty/ol.js');
        Requirements::javascript('openlayers3/javascript/OL3.base.js');
        Requirements::javascript('openlayers3/javascript/OL3.html.js');
        Requirements::javascript('openlayers3/javascript/OL3.layer.js');
        Requirements::javascript('openlayers3/javascript/OL3.init.js');
    }

    /**
     * Getter for FieldList that is used for CRUD forms for this class.
     * Conatins field customisations, fine tuning GridFields, removing redundant
     * fields and adding desriptions.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($field = $fields->dataFieldByName('Layers')) {
            $field->getConfig()
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponent(new GridFieldDeleteAction());
            if (class_exists('GridFieldSortableRows')) {
                $field->getConfig()->addComponent(new GridFieldSortableRows('SortOrder'));
            }
        }

        if ($this->Layers()->Count()) {
            $fields->dataFieldByname('BackgroundID')->setSource($this->Layers()->map());
        } else {
            $fields->removeByName('BackgroundID');
        }

        $fields->dataFieldByName('Zoom')->setRange(0, 30);
        $fields->addFieldsToTab('Root.Constraints', [
            $fields->dataFieldByName('MinZoom')->setRange(0, 30),
            $fields->dataFieldByName('MaxZoom')->setRange(0, 30),
            $fields->dataFieldByName('MinLat'),
            $fields->dataFieldByName('MinLon'),
            $fields->dataFieldByName('MaxLat'),
            $fields->dataFieldByName('MaxLon'),
        ]);

        $fields->dataFieldByName('Projection')->setDescription('Common values are "EPSG:3857" or "EPSG:4326", leave empty for server side default projection');

        return $fields;
    }

    /**
     * @return mixed (boolean | ValidationResult)
     */
    public function validate()
    {
        $result = parent::validate();

        if ((!$this->MaxZoom || !$this->MinZoom) && !$this->Zoom) {
            return true;
        }

        if ($this->MaxZoom < $this->Zoom) {
            $result->error('MaxZoom must be greater than Zoom');
        }

        if ($this->MinZoom > $this->Zoom) {
            $result->error('MinZoom must be less than Zoom');
        }

        return $result;
    }
}
