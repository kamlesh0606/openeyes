<?php
/**
 * (C) OpenEyes Foundation, 2018
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>



<div class="box admin">
    <h2>Common Ophthalmic Disorder</h2>

    <form method="get">
        <div class="data-group">
            <div class="cols-2 column"><label for="subspecialty_id">Subspecialty</label></div>
            <div class="cols-5 column end">
                <?php echo CHtml::dropDownList('subspecialty_id', $subspecialty_id, CHtml::listData($subspecialty, 'id', 'name')); ?>
            </div>
        </div>
    </form>

    <form method="POST" action="/admin/editcommonophthalmicdisorder?subspecialty_id=<?=$subspecialty_id;?>">
        <input type="hidden" class="no-clear" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken?>" />
        <?php
            $columns = array(
                array(
                    'header' => 'Order',
                    'type' => 'raw',
                    'value' => function($data, $row){
                        return '<span>&uarr;&darr;</span>' .
                            CHtml::hiddenField("CommonOphthalmicDisorder[$row][id]", $data->id) .
                            CHtml::hiddenField("display_order[$row]", $data->display_order);
                    },
                    'cssClassExpression' => "'reorder'",
                ),
                array(
                    'header' => 'Disorder',
                    'name' => 'disorder.term',
                    'type' => 'raw',
                    'htmlOptions'=>array('width'=>'200px'),
                    'value' => function($data, $row){
                        $term = null;
                        if($data->disorder){
                            $term = $data->disorder->term;
                        }
                        return CHtml::textField((get_class($data) . "[$row][disorder_id]"), $term, array(
                            'class' => 'diagnoses-search-autocomplete',
                            'data-saved-diagnoses' => $data->disorder ? json_encode(array(
                                'id' => $data->id,
                                'name' => $data->disorder->term,
                                'disorder_id' => $data->disorder->id,

                            )) : ''
                        ));
                    }
                ),
                array(
                    'header' => 'Group',
                    'name' => 'group.name',
                    'type' => 'raw',
                    'value' => function($data,$row){
                        $options = CHtml::listData(CommonOphthalmicDisorderGroup::model()->findAll(), 'id', 'name');
                        return CHtml::activeDropDownList($data, "[$row]group_id", $options, array('empty' => '-- select --'));
                    }
                ),
                array(
                    'header' => 'Finding',
                    'name' => 'finding.name',
                    'type' => 'raw',
                    'value' => function($data, $row){

                        $finding_data = array(
                            'id' => isset($data->id) ? $data->id : null,
                            'name' => isset($data->finding) ? $data->finding->name : null,
                            'finding_id' => isset($data->finding) ? $data->finding->id : null,
                        );

                        $remove_a = CHtml::tag('a',array('href' => 'javascript:void(0)', 'class' => 'finding-rename'),
                            Chtml::tag('i', array('class' => 'oe-i remove-circle small', 'aria-hidden' => "true", 'title' => "Change finding"), null)
                        );

                        $name_span = CHtml::tag('span',array('class' => 'finding-name name'), $finding_data['name']);
                        $rename_span = CHtml::tag('span',array(
                            'class'=>"finding-display display",
                            'style'=>'display: ' . ($finding_data['finding_id'] ? 'inline' : 'none') . ';'
                        ),$remove_a . ' ' . $name_span);

                        $input = CHtml::textField("CommonOphthalmicDisorder[$row][finding_id]", $finding_data['name'], array(
                            'class' => 'finding-search-autocomplete finding-search-inputfield ui-autocomplete-input',
                            'style' => 'display: '. ($finding_data['finding_id'] ? 'none' : 'inline') .';',
                            'autocomplete' => 'off',
                        ));

                        $hidden_finding_input = CHtml::hiddenField("CommonOphthalmicDisorder[$row][finding_id]", $finding_data['finding_id'],array(
                            'class' => 'finding-id'
                        ));

                        return $rename_span . $input . $hidden_finding_input;

                    }
                ),
                array(
                    'header'=>'Alternate Disorder',
                    'name' => 'alternate_disorder.term',
                    'type' => 'raw',
                    'value' => function($data, $row){

                        $alternate_disorder_data = array(
                            'id' => isset($data->id) ? $data->id : null,
                            'name' => isset($data->alternate_disorder) ? $data->alternate_disorder->term : null,
                            'alternate_disorder_id' => isset($data->alternate_disorder) ? $data->alternate_disorder->id : null,
                        );


                        $remove_a = CHtml::tag('a',array('href' => 'javascript:void(0)', 'class' => 'alternate-disorder-rename'),
                            Chtml::tag('i', array('class' => 'oe-i remove-circle small', 'aria-hidden' => "true", 'title' => "Change disorder"), null)
                        );

                        $name_span = CHtml::tag('span',array('class' => 'alternate-disorder-name name'), $alternate_disorder_data['name']);
                        $rename_span = CHtml::tag('span',array(
                            'class'=>"alternate-disorder-display display",
                            'style'=>'display: ' . ($alternate_disorder_data['alternate_disorder_id'] ? 'inline' : 'none') . ';'
                        ),$remove_a . ' ' . $name_span);


                        $input = CHtml::textField("CommonOphthalmicDisorder[$row][alternate_disorder_id]", $alternate_disorder_data['alternate_disorder_id'], array(
                            'class' => 'alternate-disorder-search-autocomplete alternate-disorder-search-inputfield ui-autocomplete-input',
                            'style' => 'display: '. ($alternate_disorder_data['alternate_disorder_id'] ? 'none' : 'inline') .';',
                            'autocomplete' => 'off',
                        ));

                        $hidden_alternate_disorder_input = CHtml::hiddenField("CommonOphthalmicDisorder[$row][alternate_disorder_id]",
                            $alternate_disorder_data['alternate_disorder_id'],array(
                                'class' => 'alternate-disorder-id'
                            ));

                        return $rename_span . $input . $hidden_alternate_disorder_input;

                    }
                ),
                array(
                    'name' => 'alternate_disorder_label',
                    'type' => 'raw',
                    'value' => function($data, $row){
                        return CHtml::activeTextField($data, "[$row]alternate_disorder_label");
                    }
                ),
                array(
                    'header'=>'Actions',
                    'type' => 'raw',
                    'value' => function($data){
                        if(!$data->secondary_to){
                            return '<a href="javascript:void(0)" class="delete">delete</a>';
                        } else {
                            return '<span title="This entry is a parent of a Secondary Common Ophtalmic Disorder" class="oe-i info small tool-tip"></span>';
                        }
                    }
                ),
            );

            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'generic-admin sortable',
                'template' => '{items}',
                "emptyTagName" => 'span',
                'rowHtmlOptionsExpression'=>'array("data-row"=>$row)',
                'enableSorting' => false,
                'columns' => $columns
            ));
        ?>
        <div>
            <button class="small secondary primary event-action" type="button" id="add_new">Add</button>&nbsp
            <button class="generic-admin-save small primary primary event-action" name="admin-save" type="submit" id="et_admin-save">Save</button>&nbsp;
        </div>
    </form>
</div>

<script>

    var $table = $('.generic-admin');

    function initialiseRow($row){
        var DiagnosesSearchController = new OpenEyes.UI.DiagnosesSearchController({
            'inputField': $row.find('.diagnoses-search-autocomplete'),
            'fieldPrefix': 'CommonOphthalmicDisorder',
            'renderCommonlyUsedDiagnoses': false,
            'code': '',
            'singleTemplate' :
            "<span class='medication-display' style='display:none'>" + "<a href='javascript:void(0)' class='diagnosis-rename'><i class='oe-i remove-circle small' aria-hidden='true' title='Change diagnosis'></i></a> " +
            "<span class='diagnosis-name'></span></span>" +
            "<select class='commonly-used-diagnosis cols-full' style='display:none'></select>" +
            "{{{input_field}}}" +
            "<input type='hidden' name='{{field_prefix}}[" + $row.data('row') + "][disorder_id]' class='savedDiagnosis' value=''>"
        });

        // Init finding, unfortunately we cannot use DiagnosesSearchController for this
        initTriggers($row, 'finding');
        initTriggers($row, 'alternate-disorder');
    }

    $(document).ready(function(){
        $('#subspecialty_id').on('change', function(){
            $(this).closest('form').submit();
        });

        $table.find('tbody tr').each(function() {
            initialiseRow($(this));
        });

        $('#add_new').on('click', function(){
            var $tr =  $('table.generic-admin tbody tr');
            var output = Mustache.render($('#common_ophthalmic_disorder_template').text(),{
                "row_count": OpenEyes.Util.getNextDataKey($tr, 'row'),
                "group_options": common_ophthalmic_disorder_group_options,
                'even_odd': $tr.length % 2 ? 'odd' : 'even',
                'order_value': parseInt($('table.generic-admin tbody tr:last-child ').find('input[name^="display_order"]').val()) + 1
            });

            $('table.generic-admin tbody').append(output);

            initialiseRow($('table.generic-admin tbody tr:last-child'));
        });

        $('.tool-tip').tooltip();
    });

    function initTriggers($row, selector){

        var $inputField = $row.find('.' + selector + '-search-inputfield');
        $row.on('click', '.' + selector + '-rename', function(){
            $inputField.show();
            $(this).closest('.' + selector + '-display').hide();

            $row.find('.' + selector + '-id').val('');

            $inputField.val('');
            $inputField.focus();
        });

        $row.on('click', 'a.delete',function(){
            $(this).closest('tr').remove();
        });

        // Autocomplete

        $inputField.autocomplete({
            minLength: 2,
            delay: 700,
            source: function (request, response) {
                $.ajax({
                    'url': '/autocomplete/search',
                    'type':'GET',
                    'data':{
                        'term': request.term,
                        'model': selector === 'finding' ? 'Finding' : 'Disorder', //yes, I know, this is awful
                        'field': selector === 'finding' ? 'name' : 'term',
                    },
                    'beforeSend': function(){
                    },
                    'success':function(data) {
                        data = $.parseJSON(data);
                        response(data);
                    }
                });
            },
            search: function () {
                $inputField.addClass('inset-loader');
            },
            select: function(event, ui){
                //controller.addDiagnosis(null, ui.item);
                $row.find('.' + selector + '-name').text(ui.item.label);
                $row.find('.' + selector + '-id').val(ui.item.id);

                $row.find('.' + selector + '-search-inputfield').hide();
                $row.find('.' + selector + '-display').show();


                //clear input
                $(this).val("");
                return false;
            },
            response: function (event, ui) {
                $inputField.removeClass('inset-loader');
            }
        });
    }
</script>

<script type="text/template" id="common_ophthalmic_disorder_template">
    <tr data-row="{{row_count}}" class="{{even_odd}}">
        <td class="reorder">
                <span>↑↓</span>
                <input type="hidden" value="" name="CommonOphthalmicDisorder[{{row_count}}][id]" id="CommonOphthalmicDisorder_{{row_count}}_id">
                <input type="hidden" value="{{order_value}}" name="display_order[{{row_count}}]" id="display_order_{{row_count}}">
        </td>
        <td width="200px">
            <span class="medication-display" style="display:none">
                <a href="javascript:void(0)" class="diagnosis-rename"><i class="oe-i remove-circle small" aria-hidden="true" title="Change diagnosis"></i></a>
                <span class="diagnosis-name"></span>
            </span>
                <input class="diagnoses-search-autocomplete diagnoses-search-inputfield ui-autocomplete-input"
                       data-saved-diagnoses="" type="text" name="CommonOphthalmicDisorder[{{row_count}}][disorder_id]" id="CommonOphthalmicDisorder_{{row_count}}_disorder_id" autocomplete="off">
                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                <input type="hidden" name="CommonOphthalmicDisorder[{{row_count}}][disorder_id]" class="savedDiagnosis" value="">
        </td>
        <td>
            <select name="CommonOphthalmicDisorder[{{row_count}}][group_id]" id="CommonOphthalmicDisorder_{{row_count}}_group_id">
                <option value="">-- select --</option>
                {{#group_options}}
                <option value="{{id}}">{{name}}</option>
                {{/group_options}}
            </select>
        </td>
        <td>
            <span class="finding-display display" style="display: none;">
                <a href="javascript:void(0)" class="finding-rename">
                    <i class="oe-i remove-circle small" aria-hidden="true" title="Change finding"></i>
                </a>
                <span class="finding-name name"></span>
            </span>
            <input class="finding-search-autocomplete finding-search-inputfield ui-autocomplete-input"
                   style="display: block;" autocomplete="off" type="text" value=""
                   name="CommonOphthalmicDisorder[{{row_count}}][finding_id]" id="CommonOphthalmicDisorder_{{row_count}}_finding_id">
            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
            <input class="finding-id" type="hidden" value="" name="CommonOphthalmicDisorder[{{row_count}}][finding_id]" id="CommonOphthalmicDisorder_{{row_count}}_finding_id">
        </td>
        <td>
            <span class="alternate-disorder-display display" style="display: none;">
                <a href="javascript:void(0)" class="alternate-disorder-rename"><i class="oe-i remove-circle small" aria-hidden="true" title="Change disorder"></i></a>
                <span class="alternate-disorder-name name"></span>
            </span>
            <input class="alternate-disorder-search-autocomplete alternate-disorder-search-inputfield ui-autocomplete-input"
                   style="display: inline;" autocomplete="off" type="text"
                   name="CommonOphthalmicDisorder[{{row_count}}][alternate_disorder_id]" id="CommonOphthalmicDisorder_{{row_count}}_alternate_disorder_id">
            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
            <input class="alternate-disorder-id" type="hidden"
                   name="CommonOphthalmicDisorder[{{row_count}}][alternate_disorder_id]" id="CommonOphthalmicDisorder_{{row_count}}_alternate_disorder_id">
        </td>
        <td>
            <input name="CommonOphthalmicDisorder[{{row_count}}][alternate_disorder_label]" id="CommonOphthalmicDisorder_{{row_count}}_alternate_disorder_label" type="text" value="">
        </td>
        <td>
            <a href="javascript:void(0)" class="delete">delete</a>
        </td>
    </tr>
</script>