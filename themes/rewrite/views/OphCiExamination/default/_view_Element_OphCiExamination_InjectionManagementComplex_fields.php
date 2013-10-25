<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>

<?php if ($element->{$side . '_no_treatment'}) {?>
	<div class="eventDetail">
		<div class="label"><?php echo CHtml::encode($element->getAttributeLabel($side . '_no_treatment_reason_id'))?></div>
		<div class="data"><?php echo $element->{$side . 'NoTreatmentReasonName'} ?></div>
	</div>
<?php } else { ?>
	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_diagnosis1_id') ?>:</div>
		<div class="data"><?php echo $element->{$side . '_diagnosis1'}->term ?></div>
	</div>


	<?php if ($element->{$side . '_diagnosis2_id'}) { ?>
		<div class="eventDetail aligned">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_diagnosis2_id') ?>:</div>
			<div class="data"><?php echo $element->{$side . '_diagnosis2'}->term ?></div>
		</div>
	<?php } ?>

	<?php foreach ($element->{$side . '_answers'} as $answer) {?>
		<div class="eventDetail aligned">
			<div class="label"><?php echo $answer->question->question ?></div>
			<div class="data"><?php echo ($answer->answer) ? 'Yes' : 'No'; ?></div>
		</div>
	<?php } ?>

	<?php if ($treatment = $element->{$side . '_treatment'}) {?>
		<div class="eventDetail aligned">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_treatment_id') ?>:</div>
			<div class="data"><?php echo $element->{$side . '_treatment'}->name ?></div>
		</div>
	<?php } ?>

	<div class="eventDetail aligned">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_risks') ?>:</div>
			<div class="data" style="display: inline-block;">
				<?php
				if (!$element->{$side . '_risks'}) {
					echo "None";
				} else {
					foreach ($element->{$side . '_risks'} as $item) {
						echo $item->name . "<br />";
					}
				}
				?>
			</div>
		</div>


	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_comments') ?>:</div>
		<div class="data"><?php echo $element->textWithLineBreaks($side . '_comments') ?></div>
	</div>
<?php }

