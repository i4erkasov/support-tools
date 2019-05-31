<?php

namespace app\modules\api\components\adapters;

use SimpleXMLElement;

/**
 * Class JsonXmlAdapter
 *
 * Данный класс выступает в виде вспомогательного инструмента
 * при помощи которого можно привести к общему типу данных (array)
 * входную строку xml|json
**/
class JsonXmlAdapter
{
    private $type = 'json';
    private $string;

    /**
     * JsonXmlAdapter constructor.
     *
     * @param string $rawString
     */
    public function __construct(string $rawString)
    {
        $this->string = $rawString;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        if ($obj = $this->xmlDecode()) {
            $this->string = json_encode($obj);
        }

        return $this->jsonDecode();
    }

    /**
     * @return SimpleXMLElement|null
     */
    private function xmlDecode(): ?SimpleXMLElement
    {
        if (@simplexml_load_string($this->string)) {
            $this->type = 'xml';

            return new SimpleXMLElement($this->string);
        }

        return null;
    }

    /**
     * @return array
     */
    private function jsonDecode(): array
    {
        $array = json_decode($this->string, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            return (isset($array['@attributes'])) ? $array['@attributes'] : $array;
        }

        $this->type = 'undefined';

        return [];
    }

    /**
     * @return string
     */
    public function getConvertType(): string
    {
        return $this->type;
    }
}
