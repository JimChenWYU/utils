<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 1/3/2019
 * Time: 7:01 PM
 */

namespace JimChen\Utils\Contracts;

interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);
}
