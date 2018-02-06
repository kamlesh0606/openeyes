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
list($values, $val_options) = $element->getUnitValuesForForm(null, false);
$methods = CHtml::listData(OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Method::model()->findAll(), 'id', 'name');
$key = 0;
?>

<?php
$this->beginClip('element-title-additional');
if ($element->isNewRecord) {
    ?>
    <?php echo CHtml::dropDownList('visualacuity_unit_change', @$element->unit_id, CHtml::listData(OEModule\OphCiExamination\models\OphCiExamination_VisualAcuityUnit::model()->activeOrPk(@$element->unit_id)->findAllByAttributes(array('is_near' => '0')), 'id', 'name'), array('class' => 'inline'));
    ?>
<?php
} ?>
<?php if ($element->unit->information) {
    ?>
    <div class="info"><small><em><?php echo $element->unit->information ?></em></small></div>
<?php
}
$this->endClip('element-title-additional');
?>
<?php
    // CVI alert
    $cvi_api = Yii::app()->moduleAPI->get('OphCoCvi');
    if($cvi_api){
        echo $cvi_api->renderAlertForVA($this->patient, $element);
        echo $form->hiddenInput($element, 'cvi_alert_dismissed', false, array('class' => 'cvi_alert_dismissed'));
    }
?>
<div class="element-fields element-eyes">
    <input type="hidden" name="visualacuity_readings_valid" value="1" />
    <?php echo $form->hiddenInput($element, 'id', false, array('class' => 'element_id')); ?>
    <?php echo $form->hiddenInput($element, 'unit_id', false); ?>
    <?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>

    <div class="element-eye right-eye column left side<?php if (!$element->hasRight()) { ?> inactive <?php } ?>" data-side="right">
        <div class="active-form field-row flex-layout">
          <a class="remove-side"><i class="oe-i remove-circle small"></i></a>
          <div class="cols-9">
            <table class="cols-full blank va_readings"<?php if (!$element->right_readings) { ?> style="display: none;" <?php } ?> >
                <tbody>
                    <?php foreach ($element->right_readings as $reading) {
                    // Adjust currently element readings to match unit steps
                        $reading->loadClosest($element->unit->id);
                        $this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
                            'name_stub' => CHtml::modelName($element).'[right_readings]',
                            'key' => $key,
                            'reading' => $reading,
                            'side' => $reading->side,
                            'values' => $values,
                            'val_options' => $val_options,
                            'methods' => $methods,
                            'asset_path' => $this->getAssetPathForElement($element),
                    ));
                        ++$key; }?>
                </tbody>
            </table>
            <div id="refraction-left-comments" class="field-row-pad-top" style="display:none;">
              <textarea placeholder="Comments" autocomplete="off" rows="1" class="js-input-comments cols-full" style="overflow: hidden; word-wrap: break-word; height: 24px;"></textarea>
            </div>
            <div class="field-row row noReadings"<?php if ($element->right_readings) { ?> style="display: none;" <?php } ?>>
                <div class="large-4 column">
                    <div class="field-info">Not recorded</div>
                </div>
                <div class="large-8 column end">
                    <?php echo $form->checkBox($element, 'right_unable_to_assess', array('text-align' => 'right', 'nowrapper' => true))?>
                    <?php echo $form->checkBox($element, 'right_eye_missing', array('text-align' => 'right', 'nowrapper' => true))?>
                </div>
            </div>
          </div>
          <div class="flex-item-bottom">
            <button class="button js-add-comments" data-input="#pupils-right-comments" type="button">
              <i class="oe-i comments small-icon"></i>
            </button>
            <button class="button hint green addReading" type="button">
              <i class="oe-i plus pro-theme"></i>
            </button>
            <!-- popup to add to element is click -->
            <div id="add-to-visual-acuity-left" class="oe-add-select-search auto-width" style="display: none;">
              <!-- icon btns -->
              <div class="close-icon-btn"><i class="oe-i remove-circle medium"></i></div>
              <div class="select-icon-btn"><i class="oe-i menu selected"></i></div>
              <button class="button hint green add-icon-btn">
                <i class="oe-i plus pro-theme"></i>
              </button>
              <!-- select (and search) options for element -->
              <table class="select-options">
                <tbody>
                <tr>
                  <td>
                    <div class="flex-layout flex-top flex-left">
                      <ul class="add-options" data-multi="true" data-clickadd="false">
                        <?php foreach ($methods as $method) { ?>
                        <li data-str="<?php echo $method; ?>"><span class="restrict-width"><?php echo $method; ?></span></li>
                        <?php } ?>
                      </ul>
                    </div> <!-- flex-layout -->
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- oe-add-select-search -->
          </div>
          <!--flex bottom-->
        </div>
      <!-- active form-->
      <div class="inactive-form" style="display: none">
        <div class="add-side">
          <a href="#">
            Add right side <span class="icon-add-side"></span>
          </a>
        </div>
      </div>
    </div>
    <div class="element-eye left-eye column right side<?php if (!$element->hasLeft()) { ?> inactive<?php }?>" data-side="left">
        <div class="active-form field-row flex-layout">
          <a class="remove-side"><i class="oe-i remove-circle small"></i></a>
          <div class="cols-9">
            <table class="cols-full blank va_readings"<?php if (!$element->left_readings) { ?> style="display: none;" <?php } ?>>
                <tbody>
                    <?php foreach ($element->left_readings as $reading) {
                        // Adjust currently element readings to match unit steps
                        $reading->loadClosest($element->unit->id);
                        $this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
                            'name_stub' => CHtml::modelName($element).'[left_readings]',
                            'key' => $key,
                            'reading' => $reading,
                            'side' => $reading->side,
                            'values' => $values,
                            'val_options' => $val_options,
                            'methods' => $methods,
                            'asset_path' => $this->getAssetPathForElement($element),
                    ));
                        ++$key;
                    }?>
                </tbody>
            </table>
            <div id="refraction-left-comments" class="field-row-pad-top" style="display:none;">
              <textarea placeholder="Comments" autocomplete="off" rows="1" class="js-input-comments cols-full" style="overflow: hidden; word-wrap: break-word; height: 24px;"></textarea>
            </div>
            <div class="field-row row noReadings"<?php if ($element->left_readings) { ?> style="display: none;" <?php } ?>>
                <div class="large-4 column">
                    <div class="field-info">Not recorded</div>
                </div>
                <div class="large-8 column">
                    <?php echo $form->checkBox($element, 'left_unable_to_assess', array('text-align' => 'right', 'nowrapper' => true))?>
                    <?php echo $form->checkBox($element, 'left_eye_missing', array('text-align' => 'right', 'nowrapper' => true))?>
                </div>
            </div>
          <!-- Cols -->
          </div>
          <div class="flex-item-bottom">
            <button class="button js-add-comments" data-input="#pupils-right-comments" type="button">
              <i class="oe-i comments small-icon"></i>
            </button>
            <button class="button hint green addReading" type="button">
              <i class="oe-i plus pro-theme"></i>
            </button>
          </div>
          <!--flex bottom-->
        </div>
      <div class="inactive-form" style="display: none">
        <div class="add-side">
          <a href="#"> Add left side <span class="icon-add-side"></span>
          </a>
        </div>
      </div>
    </div>
</div>
<script id="visualacuity_reading_template" type="text/html">
    <?php
    $default_reading = OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Reading::model();
    $default_reading->init();
    $this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
            'name_stub' => CHtml::modelName($element).'[{{side}}_readings]',
            'key' => '{{key}}',
            'side' => '{{side}}',
            'values' => $values,
            'val_options' => $val_options,
            'methods' => $methods,
            'asset_path' => $this->getAssetPathForElement($element),
            'reading' => $default_reading,
    ));
    ?>
</script>
<?php
    $assetManager = Yii::app()->getAssetManager();
    $baseAssetsPath = Yii::getPathOfAlias('application.assets');
    $assetManager->publish($baseAssetsPath.'/components/chosen/');

    Yii::app()->clientScript->registerScriptFile($assetManager->getPublishedUrl($baseAssetsPath.'/components/chosen/').'/chosen.jquery.min.js');
    Yii::app()->clientScript->registerCssFile($assetManager->getPublishedUrl($baseAssetsPath.'/components/chosen/').'/chosen.min.css');

?>
<script type="text/javascript">
    $(document).ready(function() {

        OphCiExamination_VisualAcuity_method_ids = [ <?php
        $first = true;
        foreach ($methods as $index => $method) {
            if (!$first) {
                echo ', ';
            }
            $first = false;
            echo $index;
        } ?> ];
    });
</script>
