<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>

<?php

if ($element->event != null && $element->event->id > 0) {
    $iolRefValues = Element_OphInBiometry_IolRefValues::Model()->findAllByAttributes(
        array(
            'event_id' => $element->event->id,
        ));
} else {
    $iolRefValues = array();
}

?>
    </section>
        <section class="element edit full  eye-divider edit-biometry"
                data-element-type-id="<?php echo $element->elementType->id ?>"
                data-element-type-class="<?php echo $element->elementType->class_name ?>"
                data-element-type-name="<?php echo $element->elementType->name ?>"
                data-element-display-order="<?php echo $element->elementType->display_order ?>">
            <div class="element-fields element-eyes">
                <?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
                <?php foreach (['left' => 'right', 'right' => 'left'] as $page_side => $eye_side):
                    $element->hasEye($eye_side);
                    ?>
                    <div class="js-element-eye <?= $eye_side ?>-eye column <?= $page_side ?> side <?= !$element->hasEye($eye_side) ? "inactive" : "" ?>"
                         data-side="<?= $eye_side ?>">
                        <div class="active-form" style="<?= $element->hasEye($eye_side) ? '' : 'display: none;' ?>">
                            <a class="remove-side"><i class="oe-i remove-circle small"></i></a>
                            <?php $this->renderPartial('form_Element_OphInBiometry_Measurement_fields', array(
                                'side' => $eye_side,
                                'element' => $element,
                                'form' => $form,
                                'data' => $data,
                                'measurementInput' => $iolRefValues,
                            )); ?>

                        </div>
                        <div class="inactive-form" style="<?= $element->hasEye($eye_side) ? 'display: none;' : '' ?>">
                            <div class="add-side">
                                <a href="#">
                                    Add <?= $eye_side ?> side <span class="icon-add-side"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
