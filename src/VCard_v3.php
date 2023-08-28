<?php

class VCard_v3 {
    public ?string $_fullname = null;
    public ?string $_lastname = null;
    public ?string $_firstname = null;
    public ?string $_surname = null;
    public ?string $_nickname = null;
    public ?string $_birthday = null;
    public ?string $_lastRevision = null;
    /**
     * @var \VCard_v3\Entity\Geo[] $phone
     */
    public array $_geos = [];
    /**
     * @var \VCard_v3\Entity\Phone[] $phone
     */
    public array $_phones = [];
    /**
     * @var \VCard_v3\Entity\Address[] $phone
     */
    public array $_addresses = [];
    /**
     * @var \VCard_v3\Entity\Email[] $phone
     */
    public array $_emails = [];

    /**
     * Parse vCard
     *
     * @param string $filename
     * @param bool   $multiply FALSE - will be returned array with one element(first VCard from file), TRUE - try to parse all VCards in file
     *
     * @return static|static[]
     *
     * @throws \Exception
     */
    public static function parse(string $filename, bool $multiply = false) : array|static {
        if (file_exists($filename) === false) {
            throw new \Exception(message: "vCard file not exist", code: 400);
        }

        $fileData = file_get_contents($filename);
        if ($fileData === false) {
            throw new \Exception(message: "Can't read vCard file", code: 400);
        }
        $fileData = str_replace("\r\n", "\n", $fileData);
        $fileData = explode("\n", $fileData);

        $data = [];
        $vCard = null;

        while ($row = array_shift($fileData)) {
            if ($row === "BEGIN:VCARD") {
                $vCard = array_shift($fileData) !== "VERSION:3.0" ? null : new static();
            }
            if ($vCard === null) { // skip row if vCard not v3.0
                continue;
            }

            [$key, $value] = explode(":", $row, 2);
            if ($value === null) { // skip row if not "$key:$value"
                continue;
            }
            $valueClarification = null;
            if (str_contains($key, ";") === true) {
                [$key, $valueClarification] = explode(";", $key, 2);
            }

            switch ($key) {
                case "FN" :
                    {
                        $vCard->_fullname = $value;
                    }
                    break;
                case "N":
                    {
                        [$vCard->_lastname, $vCard->_firstname, $vCard->_surname] = explode(";", $value);
                    }
                    break;
                case "NICKNAME":
                    {
                        $vCard->_nickname = $value;
                    }
                    break;
                case "BDAY":
                    {
                        $vCard->_birthday = strtotime($value);
                    }
                    break;
                case "REV":
                    {
                        $vCard->_lastRevision = strtotime($value);
                    }
                    break;
                case "GEO":
                    {
                        $vCard->_geos[] = \VCard_v3\Entity\Geo::parse($row);
                    }
                    break;
                case "TEL":
                    {
                        $vCard->_phones[] = \VCard_v3\Entity\Phone::parse($row);
                    }
                    break;
                case "ADR":
                    {
                        $vCard->_addresses[] = \VCard_v3\Entity\Address::parse($row);
                    }
                    break;
                case "EMAIL":
                    {
                        $vCard->_emails[] = \VCard_v3\Entity\Email::parse($row);
                    }
                    break;
            }

            $x = [
                "FN"       => "fullname",
                "N"        => "фамилия; имя; отчество (дополнительные имена); префиксы; суффиксы",
                "NICKNAME" => "nickname",
                "BDAY"     => "date in ISO - use strtotime for parse",
                "REV"      => "date in ISO - use strtotime for parse",
                "GEO"      => "GEO:93.657415,-122.082932",
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
                "ADR"      => "абонентский ящик; расширенный адрес; дом и улица; населённый пункт; регион (штат, область); почтовый индекс; страна|",
                /**
                 * Can be clarified by TYPE=... , after TEL;(can be few values)
                 *
                 * home — по месту проживания;
                 * msg — поддерживает передачу голосовых сообщений
                 * work — по месту работы
                 * pref — предпочитаемый, если известно более одного телефона
                 * voice — для голосового общения
                 * fax — для передачи факсов
                 * cell — сотовый
                 * video — поддерживает видеоконференции
                 * pager — для передачи сообщений на пейджер
                 * bbs — обслуживает электронную доску объявлений
                 * modem — по этому номеру работает модем
                 * car — в автомобиле
                 * isdn — предоставляет услуги ISDN
                 * pcs — personal communication services
                 */
                "TEL"      => "",
                /**
                 * Can be clarified by EMAIL=... , after TEL;(can be few values)
                 *
                 * internet — адрес в формате интернета
                 * x400 — адрес в формате X.400
                 * pref — предпочитаемый, если известно более одного адреса электронной почты
                 */
                "EMAIL"    => "",
            ];


            if ($row === "END:VCARD") {
                if ($multiply === false) {
                    return $vCard;
                }

                $data[] = $vCard;
                $vCard = null;
            }
        }
        if ($vCard !== null) {
            $data[] = $vCard;
        }

        return $data;
    }
}
