<?php
/**
 * (C) OpenEyes Foundation, 2014
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2014, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * Base class for widgets that allow selecting values from a lookup table.
 */
abstract class SelectionWidget extends BaseFieldWidget
{
    /**
     * Data as generated by CHtml::listData or model class name.
     *
     * If a class name is specified the data will be taken from that table
     */
    public $data;

    public function init()
    {
        parent::init();

        if (is_string($this->data)) {
            $value = isset($this->element->{$this->field}) ? $this->element->{$this->field} : null;
            $this->data = SelectionHelper::listData($this->data, $value);
        }
    }
}
