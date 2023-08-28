<?php


namespace VCard_v3\Entity;
class Geo extends \VCard_v3\Entity {
    /**
     * Latitude
     *
     * @var float
     */
    protected float $_latitude;
    /**
     * Longitude
     *
     * @var float
     */
    protected float $_longitude;

    /**
     * @inheritDoc
     */
    public static function parse(string $row) : static {
        $instance = new static();

        /**
         * "GEO"      => "GEO:93.657415,-122.082932",
         */
        [, $value] = explode(":", $row);
        [$latitude, $longitude] = explode(",", str_replace(" ", '', $value));
        $instance->_latitude = (float) $latitude;
        $instance->_longitude = (float) $longitude;

        return $instance;
    }
}
