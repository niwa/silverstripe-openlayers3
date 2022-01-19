<?php

namespace App\OL3\model\sources;




/**
 * File contains the OL3VectorSource class.
 *
 * @package openlayers3
 * @author Catalyst SilverStripe Team <silverstripedev@catalyst.net.nz>
 */

/**
 * A wrapper for ol.source.Vector
 * @link https://openlayers.org/en/latest/apidoc/ol.source.Vector.html
 */

class OL3VectorSource extends OL3Source
{
    /**
     * Map of class properties to persist in the database
     * Keys are property names, values are data types
     * @var array
     */
    private static $db = [
        'Format' => "Enum('GeoJSON, GML','GeoJSON')",
        'Url' => 'Varchar(255)',
        'FeatureTypes' => 'Varchar',
        'Projection' => 'Varchar',
    ];

    /**
     * Getter for FieldList that is used for CRUD forms for this class
     * Conatins field customisations, adds FormField::$description
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($this->Format == 'GML') {
            $fields->dataFieldByName('FeatureTypes')
                ->setDescription('Comma separated list of names to identify layers on the server side');
            $fields->dataFieldByName('Projection')
                ->setDescription('Common values are "EPSG:3857" or "EPSG:4326", leave empty for server side default projection');
        } else {
            $fields->dataFieldByName('Url')
                ->setDescription('Use the "$extent" url variable to limit the amount of features, e.g. .../GetFeatures.json?bbox=$extent');
            $fields->removeByName('Projection');
            $fields->removeByName('FeatureTypes');
        }

        return $fields;
    }
}
