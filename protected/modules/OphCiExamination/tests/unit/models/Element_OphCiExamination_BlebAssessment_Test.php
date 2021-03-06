<?php

/**
 * OpenEyes.
 *
 * (C) OpenEyes Foundation, 2016
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2016, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
class Element_OphCiExamination_BlebAssessment_Test extends CDbTestCase
{
    /**
     * @var Element_OphCiExamination_BlebAssessment
     */
    protected $model;
    public $fixtures = array(
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->model = new OEModule\OphCiExamination\models\Element_OphCiExamination_BlebAssessment();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers OEModule\OphCiExamination\models\Element_OphCiExamination_BlebAssessment::model
     */
    public function testModel()
    {
        $this->assertEquals('OEModule\OphCiExamination\models\Element_OphCiExamination_BlebAssessment', get_class($this->model), 'Class name should match model.');
        $this->assertTrue(is_subclass_of($this->model, 'SplitEventTypeElement'));
    }

    /**
     * @covers OEModule\OphCiExamination\models\Element_OphCiExamination_BlebAssessment::tableName
     */
    public function testTableName()
    {
        $this->assertEquals('et_ophciexamination_bleb_assessment', $this->model->tableName());
    }
}
