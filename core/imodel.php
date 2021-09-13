<?php

namespace Core;

/**
 *
 * @date 11 sep. 2021
 * @time 14:15:26
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
interface IModel
{

    public function save();

    public function getAll();

    public function get($id);

    public function delete($id);

    public function update();

    public function from($array);
}
