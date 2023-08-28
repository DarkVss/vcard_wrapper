<?php


namespace VCard_v3\Entity;
class Phone extends \VCard_v3\Entity {
    /**
     * по месту проживания
     */
    public const TYPE_HOME = "home";
    /**
     * поддерживает передачу голосовых сообщений
     */
    public const TYPE_MSG = "msg";
    /**
     * по месту работы
     */
    public const TYPE_WORK = "work";
    /**
     * предпочитаемый, если известно более одного телефона
     */
    public const TYPE_PREF = "pref";
    /**
     * для голосового общения
     */
    public const TYPE_VOICE = "voice";
    /**
     * для передачи факсов
     */
    public const TYPE_FAX = "fax";
    /**
     * сотовый
     */
    public const TYPE_CELL = "cell";
    /**
     * поддерживает видеоконференции
     */
    public const TYPE_VIDEO = "video";
    /**
     * для передачи сообщений на пейджер
     */
    public const TYPE_PAGER = "pager";
    /**
     * обслуживает электронную доску объявлений
     */
    public const TYPE_BBS = "bbs";
    /**
     * по этому номеру работает модем
     */
    public const TYPE_MODEM = "modem";
    /**
     * в автомобиле
     */
    public const TYPE_CAR = "car";
    /**
     * предоставляет услуги ISDN
     */
    public const TYPE_ISDN = "isdn";
    /**
     * personal communication services
     */
    public const TYPE_PCS = "pcs";

    public const AVAILABLE_TYPES = [
        self::TYPE_HOME,
        self::TYPE_MSG,
        self::TYPE_WORK,
        self::TYPE_PREF,
        self::TYPE_VOICE,
        self::TYPE_FAX,
        self::TYPE_CELL,
        self::TYPE_VIDEO,
        self::TYPE_PAGER,
        self::TYPE_BBS,
        self::TYPE_MODEM,
        self::TYPE_CAR,
        self::TYPE_ISDN,
        self::TYPE_PCS,
    ];

    /**
     * Phone value
     *
     * @var string
     */
    protected string $_value;
    /**
     * Phone types
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
