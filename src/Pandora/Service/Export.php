<?php
namespace Pandora\Service;


class Export implements \JsonSerializable
{
    function srcFieldFormat(array $fields) {
        foreach ($fields as $key => $val) {
            if (is_array($val)) {
               $fields[$key] = $this->srcFieldFormat($val);
               continue;
            }

            if (substr($val, 0, 1) == '#') {
               continue;
            }

            $fields[$key] = '#' . $val;
        }
        return $fields;
    }

    public function jsonSerialize()
    {
        $jsonVars = [];
        $vars = get_object_vars($this);

        foreach ($vars as $key => $var) {
            if (!empty($var)) {
               $jsonVars[$key] = $var;
            }
        }

        return $jsonVars;
    }
}