<?php


namespace VCard_v3\Entity;
class Email extends \VCard_v3\Entity {
    /**
     * Адрес в формате интернета
     */
    public const TYPE_INTERNET = "internet";
    /**
     * адрес в формате X.400
     */
    public const TYPE_X400 = "x400";
    /**
     * Предпочитаемый, если известно более одного адреса электронной почты
     */
    public const TYPE_PREF = "pref";

    public const AVAILABLE_TYPES = [
        self::TYPE_INTERNET,
        self::TYPE_X400,
        self::TYPE_PREF,
    ];

    /**
     * Email value
     *
     * @var string
     */
    protected string $_value;
    /**
     * Email types
     *
     * @var array
     */
    protected array $_types;

    /**
     * @inheritDoc
     */
    public static function parse(string $row) : static {
        $instance = new static();

        [$identifications, $instance->_value] = explode(":", $row);
        $types = static::_parsePropertyTypes($identifications);
        foreach ($types as $type) {
            [, $value] = explode("=", $type);
            if (in_array($value, static::AVAILABLE_TYPES) === true) {
                $instance->_types[] = $value;
            }
        }

        return $instance;
    }
}
