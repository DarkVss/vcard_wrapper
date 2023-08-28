<?php

namespace VCard_v3;

abstract class Entity {
    /**
     * Parse row(full row from vCard file) data to entity
     *
     * @param string $row
     *
     * @return static
     */
    abstract public static function parse(string $row) : static;

    final protected static function _parsePropertyTypes(string $keyAndTypes) : array {
        if (str_contains($keyAndTypes, ";") === true) {
            [, $identifications] = explode(";", $keyAndTypes, 2);
            $identifications = strtolower(str_replace(" ", '', $identifications));
            if (str_contains(",", $identifications) === true) {
                [, $identifications] = explode("=", $identifications, 2);
                $types = explode(",", $identifications);
            } else if (str_contains($identifications, ";") === true) {
                $types = explode(";", $identifications);
            }
        }

        return $types ?? [];
    }
}
