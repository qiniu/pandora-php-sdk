<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 下午4:55
 */

namespace Pandora\Service;


class Export
{
    function srcFieldFormat(array $fields) {
        foreach ($fields as $key => $val) {
            if (is_array($val)) {
               $fields[$key] = srcFieldFormat($val);
               continue;
            }

            if (substr($val, 0, 1) == '#') {
               continue;
            }

            $fields[$key] = '#' . $val;
        }
        return $fields;
    }
}