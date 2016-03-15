<?php
/**
 * OpenEyes
 *
 * (C) OpenEyes Foundation, 2014
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

class NodExportControllerTest extends CDbTestCase
{
        protected $date;
        protected $mock;
        protected $controller;
        
        public function setUp()
	{
            parent::setUp();

            $this->date = $date = date('YmdHi');
            $this->mock = $this->getMockBuilder('NodExportController')->disableOriginalConstructor()->getMock();
            
            $this->mock->method('createAllTempTables');
            
            $reflectionClass = new ReflectionClass('NodExportController');
            
            $institutionCode = $reflectionClass->getProperty('institutionCode');
            $institutionCode->setAccessible(true);
            $institutionCode->setValue($this->mock, 'TEST_INSTITUTION');
            
            $exportPath = $reflectionClass->getProperty('exportPath');
            $exportPath->setAccessible(true);
            $exportPath->setValue($this->mock, (realpath(dirname(__FILE__) . '/../../../') . '/runtime/nod-export/test/' . $institutionCode->getValue($this->mock) . '/' . $this->date));
            
            $zipName = $reflectionClass->getProperty('zipName');
            $zipName->setAccessible(true);
            $zipName->setValue($this->mock, ( $institutionCode->getValue($this->mock) . '_' . $this->date . '_NOD_Export.zip' ) );
            
            $this->controller = $reflectionClass;
            $this->exportPath = $exportPath->getValue($this->mock);
            $this->zipName = $zipName->getValue($this->mock);
            
            if (!file_exists($exportPath->getValue($this->mock))) {
                mkdir( $exportPath->getValue($this->mock) , 0777, true);
            }
            
            $createAllTempTablesmethod = $this->controller->getMethod('createAllTempTables');
            $createAllTempTablesmethod->setAccessible(true);
            $createAllTempTablesmethod->invoke($this->mock);
       
	}
        
        /**
         * Generates CSV and zip file then test the zip if exsist and size > 0
         */
	public function testgenerateExport()
	{
            
            $actionGetAllEpisodeId = $this->controller->getMethod('actionGetAllEpisodeId');
            $actionGetAllEpisodeId->setAccessible(true);
            $actionGetAllEpisodeId->invoke($this->mock);
            
            $generateExportMethod = $this->controller->getMethod('generateExport');
            $generateExportMethod->setAccessible(true);
            $generateExportMethod->invoke($this->mock);
        
            $createZipFileMethod = $this->controller->getMethod('createZipFile');
            $createZipFileMethod->setAccessible(true);
            $createZipFileMethod->invoke($this->mock);
            
            $this->assertFileExists( $this->exportPath . '/' . $this->zipName );
            
            $this->assertGreaterThan(0, filesize($this->exportPath . '/' . $this->zipName));
        }
        
        protected function getCSVHeader($file)
        {
            $file = fopen($file, 'r');
            
            $data = fgetcsv($file);
            fclose($file);
            return $data;
        }
        
        /**
         * Test the Surgeon CSV files if they are exsist and the file size > 0
         * also check the headers
         */
        public function testSurgeons()
        {
            $file = $this->exportPath . '/' . 'Surgeons.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            
            $header = $this->getCSVHeader($file);
            
            $this->assertEquals($header, array(
                'Surgeonid', 'GMCnumber', 'Title', 'FirstName', 'CurrentGradeId'
            ));
        }
        
        /**
         * Test the Patient CSV files if they are exsist and the file size > 0
         */
        public function testPatients()
        {
            $file = $this->exportPath . '/' . 'Patients.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            
            $header = $this->getCSVHeader($file);
           
            $this->assertEquals($header, array(
                'PatientId', 'GenderId', 'EthnicityId', 'DateOfBirth', 'DateOfDeath', 'IMDScore', 'IsPrivate'
            ));
        }
        
        /**
         * Test the PatientCviStatus CSV files if they are exsist and the file size > 0
         */
        public function testPatientCviStatus()
        {
            $file = $this->exportPath . '/' . 'PatientCviStatus.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
            $this->assertEquals($header, array(
                'PatientId', 'Date', 'IsDateApprox', 'IsCVIBlind', 'IsCVIPartial'
            ));
        }
        
        /**
         * Test the Episodes CSV files if they are exsist and the file size > 0
         */
        public function testEpisodes()
        {
            $file = $this->exportPath . '/' . 'Episodes.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
            
             $this->assertEquals($header, array(
                'PatientId', 'EpisodeId', 'Date'
            ));
            

        }
        
         /**
         * Test the EpisodeDiagnosis CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeDiagnosis()
        {
            $file = $this->exportPath . '/' . 'EpisodeDiagnosis.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'Date', 'SurgeonId', 'ConditionId', 'DiagnosisTermId'
            ));
        }
        
        
        /**
         * Test the EpisodeDiagnosis CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeDiabeticDiagnosis()
        {
            $file = $this->exportPath . '/' . 'EpisodeDiabeticDiagnosis.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'IsDiabetic', 'DiabetesTypeId', 'DiabetesRegimeId', 'AgeAtDiagnosis'
            ));
        }
        
        
        /**
         * Test the EpisodeDrug CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeDrug()
        {
            $file = $this->exportPath . '/' . 'EpisodeDrug.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'DrugId', 'DrugRouteId', 'StartDate', 'StopDate', 'IsAddedByPrescription', 'IsContinueIndefinitely', 'IsStartDateApprox'
            ));
        }
        
        /**
         * Test the EpisodeDrug CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeBiometry()
        {
            $file = $this->exportPath . '/' . 'EpisodeBiometry.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'AxialLength', 'BiometryAScanId', 'BiometryKeratometerId', 
                'BiometryFormulaId', 'K1PreOperative', 'K2PreOperative', 'AxisK1', 'AxisK2', 'ACDepth', 'SNR'
            ));
        }
        
        
        /**
         * Test the EpisodeIOP CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeIOP()
        {
            $file = $this->exportPath . '/' . 'EpisodeIOP.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'Type', 'GlaucomaMedicationStatusId', 'Value', 
            ));
        }
        
        /**
         * Test the EpisodePreOpAssessment CSV files if they are exsist and the file size > 0
         */
        public function testEpisodePreOpAssessment()
        {
            $file = $this->exportPath . '/' . 'EpisodePreOpAssessment.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'IsAbleToLieFlat', 'IsInabilityToCooperate',
            ));
        }
        
        
        /**
         * Test the EpisodeRefraction CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeRefraction()
        {
            $file = $this->exportPath . '/' . 'EpisodeRefraction.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'RefractionTypeId', 'Sphere', 'Cylinder', 'Axis', 'ReadingAdd',
            ));
        }
        
        /**
         * Test the EpisodeVisualAcuity CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeVisualAcuity()
        {
            $file = $this->exportPath . '/' . 'EpisodeVisualAcuity.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'Eye', 'NotationRecordedId', 'BestMeasure', 'Unaided', 'Pinhole', 'BestCorrected'
            ));
        }
        
        /**
         * Test the EpisodeOperation CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeOperation()
        {
            $file = $this->exportPath . '/' . 'EpisodeOperation.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'OperationId', 'EpisodeId', 'Description', 'IsHypertensive', 'ListedDate', 'SurgeonId', 'SurgeonGradeId', 'AssistantId', 'AssistantGradeId', 'ConsultantId'
            ));
        }
        
        
        /**
         * Test the EpisodeOperationComplication CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeOperationComplication()
        {
            $file = $this->exportPath . '/' . 'EpisodeOperationComplication.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'OperationId', 'Eye', 'ComplicationTypeId'
            ));
        }
        
        /**
         * Test the EpisodeOperationIndication CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeOperationIndication()
        {
            $file = $this->exportPath . '/' . 'EpisodeOperationIndication.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'OperationId', 'Eye', 'IndicationId'
            ));
        }
        
        /**
         * Test the EpisodeOperationCoPathology CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeOperationCoPathology()
        {
            $file = $this->exportPath . '/' . 'EpisodeOperationCoPathology.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'OperationId', 'Eye', 'CoPathologyId'
            ));
        }
        
        
        /**
         * Test the EpisodeOperationAnaesthesia CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeOperationAnaesthesia()
        {
            $file = $this->exportPath . '/' . 'EpisodeOperationAnaesthesia.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'OperationId', 'AnaesthesiaTypeId', 'AnaesthesiaNeedle', 'Sedation', 'SurgeonId', 'ComplicationId'
            ));
        }
        
        /**
         * Test the EpisodeTreatment CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeTreatment()
        {
            $file = $this->exportPath . '/' . 'EpisodeTreatment.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'TreatmentId', 'OperationId', 'Eye', 'TreatmentTypeId',
            ));
        }
        
        /**
         * Test the EpisodeTreatment CSV files if they are exsist and the file size > 0
         */
        public function testEpisodeTreatmentCataract()
        {
            $file = $this->exportPath . '/' . 'EpisodeTreatmentCataract.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'TreatmentId', 'IsFirstEye', 'PreparationDrugId', 'IncisionSiteId', 'IncisionLengthId', 
                'IncisionPlanesId', 'IncisionMeridean', 'PupilSizeId', 'IOLPositionId', 'IOLModelId', 'IOLPower', 'PredictedPostOperativeRefraction', 'WoundClosureId'
            ));
        }
        
        /**
         * Test the EpisodePostOpComplication CSV files if they are exsist and the file size > 0
         */
        public function testEpisodePostOpComplication()
        {
            $file = $this->exportPath . '/' . 'EpisodePostOpComplication.csv';
            $this->assertFileExists( $file );
            $this->assertGreaterThan(0, filesize($file));
            $header = $this->getCSVHeader($file);
             
            $this->assertEquals($header, array(
                'EpisodeId', 'OperationId', 'Eye', 'ComplicationTypeId'
            ));
        }
            
        public function tearDown() {
            parent::tearDown();
            
            $clearAllTempTablesmethod = $this->controller->getMethod('clearAllTempTables');
            $clearAllTempTablesmethod->setAccessible(true);
            $clearAllTempTablesmethod->invoke($this->mock);
        }
}