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

<div class="cols-7">

    <?php if (!$opcsCodes) : ?>
        <div class="row divider">
            <div class="alert-box issue"><b>No results found</b></div>
        </div>
    <?php endif; ?>

    <div class="row divider">
        <form id="procedures_search" method="post">
            <input type="hidden" name="YII_CSRF_TOKEN" value="<?= Yii::app()->request->csrfToken ?>"/>
            <table class="cols-full">
                <colgroup>
                    <col class="cols-10">
                    <col class="cols-1">
                    <col class="cols-1">
                </colgroup>

                <tbody>
                <tr class="col-gap">
                    <td>
                        <?=\CHtml::textField(
                            'search[query]',
                            $search['query'],
                            [
                                'class' => 'cols-full',
                                'placeholder' => "Id, Name"
                            ]
                        ); ?>
                    </td>
                    <td>
                        <?= \CHtml::dropDownList(
                            'search[active]',
                            $search['active'],
                            [
                                1 => 'Only Active',
                                0 => 'Exclude Active',
                            ],
                            ['empty' => 'All']
                        ); ?>
                    </td>
                    <td>
                        <button class="blue hint"
                                type="submit" id="et_search">Search
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>


    <form id="admin_benefits" method="post">
        <input type="hidden" name="YII_CSRF_TOKEN" value="<?= Yii::app()->request->csrfToken ?>"/>

        <table class="standard">
            <thead>
            <tr>
                <th><input type="checkbox" name="selectall" id="selectall"/></th>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Active</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($opcsCodes as $key => $opcsCode) { ?>
                <tr id="$key" class="clickable" data-id="<?php echo $opcsCode->id ?>"
                    data-uri="oeadmin/opcsCode/edit/<?php echo $opcsCode->id ?>?returnUri=">
                    <td>
                        <?php if ($this->isOpcsCodeDeletable($opcsCode)) : ?>
                            <input type="checkbox" name="select[]" value="<?php echo $opcsCode->id ?>"
                                   id="select[<?= $opcsCode->id ?>]"/>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $opcsCode->id ?></td>
                    <td><?php echo $opcsCode->name ?></td>
                    <td><?php echo $opcsCode->description ?></td>
                    <td>
                        <?php echo ($opcsCode->active) ?
                            ('<i class="oe-i tick small"></i>') :
                            ('<i class="oe-i remove small"></i>'); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

            <tfoot class="pagination-container">
            <tr>
                <td colspan="3">
                    <?=\CHtml::submitButton(
                        'Add',
                        [
                            'class' => 'button large',
                            'data-uri' => '/oeadmin/opcsCode/edit',
                            'name' => 'add',
                            'id' => 'et_add'
                        ]
                    ); ?>
                    <?=\CHtml::submitButton(
                        'Delete',
                        [
                            'class' => 'button large disabled',
                            'name' => 'delete',
                            'data-object' => 'benefit',
                            'data-uri' => '/oeadmin/opcsCode/delete',
                            'id' => 'et_delete',
                            'disabled' => true,

                        ]
                    ); ?>
                </td>
                <td colspan="2">
                    <?php $this->widget(
                        'LinkPager',
                        ['pages' => $pagination]
                    ); ?>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>

<script>
    $(document).ready(function () {

        /**
         * Deactivate button when no checkbox is selected.
         */
        $(this).on('change', $('input[type="checkbox"]'), function (e) {
            var checked_boxes = $('#admin_benefits').find('table.standard tbody input[type="checkbox"]:checked');

            if (checked_boxes.length <= 0) {
                $('#et_delete').attr('disabled', true).addClass('disabled');
            } else {
                $('#et_delete').attr('disabled', false).removeClass('disabled');
            }
        });
    });
</script>


