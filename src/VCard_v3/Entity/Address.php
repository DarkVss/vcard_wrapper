<?php


namespace VCard_v3\Entity;
class Address extends \VCard_v3\Entity {
    /**
     * местный
     *
     * @var ?string
     */
    public ?string $_dom = null;
    /**
     * международный
     *
     * @var ?string
     */
    public ?string $_intl = null;
    /**
     * для писем
     *
     * @var ?string
     */
    public ?string $_postal = null;
    /**
     * для посылок
     *
     * @var ?string
     */
    public ?string $_parcel = null;
    /**
     * место проживания
     *
     * @var ?string
     */
    public ?string $_home = null;
    /**
     * место работы
     *
     * @var ?string
     */
    public ?string $_work = null;
    /**
     * предпочитаемый, если известно более одного адреса
     *
     * @var ?string
     */
    public ?string $_pref = null;

    /**
     * @inheritDoc
     */
    public static function parse(string $row) : static {
        $instance = new static();

        /**
         * Can be clarified by TYPE=... , after ADR;
         *
         * dom — местный
         * intl — международный
         * postal — для писем
         * parcel — для посылок
         * home — место проживания
         * work — место работы
         * pref — предпочитаемый, если известно более одного адреса
         */

        return $instance;
    }
}
