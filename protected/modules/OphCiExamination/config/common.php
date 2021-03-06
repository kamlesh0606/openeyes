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

return array(
    'components' => array(
        'event' => array(
            'observers' => array(
                'after_medications_save' => array(
                    'update_patient_risks' => array(
                        'class' => 'OEModule\OphCiExamination\components\HistoryRisksManager',
                        'method' => 'addPatientMedicationRisks'
                    )
                )
            )
        )
    ),
    'params' => array(
        'admin_menu' => array(
            'Element Attributes' => array('OphCiExamination' => '/oeadmin/ExaminationElementAttributes/list'),
            'Workflows' => '/OphCiExamination/admin/viewWorkflows',
            'Workflow rules' => '/OphCiExamination/admin/viewWorkflowRules',
            'Allergies' => '/OphCiExamination/admin/Allergies',
            'Required Allergy Assignment' => '/OphCiExamination/oeadmin/AllergyAssignment',
            'Risks' => '/OphCiExamination/admin/Risks',
            'Required Risk Assignment' => '/OphCiExamination/oeadmin/RisksAssignment',
            'Required Systemic Diagnoses Assignment' => '/OphCiExamination/oeadmin/systemicDiagAssignment',
            'Required Surgical History Assignment' => '/OphCiExamination/oeadmin/SurgicalHistoryAssignment',
            'Surgical History' => array('OphCiExamination' => '/admin/editpreviousoperation'),
            'Social History' => '/OphCiExamination/admin/SocialHistory',
            'Family History' => '/OphCiExamination/admin/FamilyHistory',
            'Comorbidities' => '/OphCiExamination/admin/manageComorbidities',
            'IOP Instruments' => '/OphCiExamination/admin/EditIOPInstruments',
            'Drop-related Problems' => '/OphCiExamination/admin/manageDropRelProbs',
            'Drops Options' => '/OphCiExamination/admin/manageDrops',
            'Surgery Management Options' => '/OphCiExamination/admin/manageManagementSurgery',
            'Follow-up Statuses' => '/OphCiExamination/admin/manageClinicOutcomesStatus',
            'Cataract surgery reasons' => '/OphCiExamination/admin/primaryReasonForSurgery',
            'Common Post-Op Complications' => '/OphCiExamination/admin/postOpComplications',
            'Medication Stop Reasons' => '/OphCiExamination/admin/HistoryMedicationsStopReason',
            'Overall Periods' => '/OphCiExamination/admin/manageOverallPeriods',
            'Visit Intervals' => '/OphCiExamination/admin/manageVisitIntervals',
            'Glaucoma Statuses' => '/OphCiExamination/admin/manageGlaucomaStatuses',
            'Target IOP Values' => '/OphCiExamination/admin/manageTargetIOPs',
            'Inject. Mgmt - No Treatment Reasons' => '/OphCiExamination/admin/viewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason',
            'Inject. Mgmt - Diagnosis Questions' => '/OphCiExamination/admin/viewOphCiExamination_InjectionManagementComplex_Question',
            'Optom Invoice Statuses' => '/OphCiExamination/admin/InvoiceStatusList',
        ),
        'ophciexamination_drgrading_type_required' => false,
        'ophciexamination_visualacuity_correspondence_unit' => 'Snellen Metre',
        'menu_bar_items' => array(
            'ofm' => array(
                'title' => 'Optom Invoice Manager',
                'position' => 9,
                'uri' => '/OphCiExamination/OptomFeedback/list',
                'restricted' => array(array('Optom co-ordinator', 'user_id')),
            )
        ),
        'reports' => array(
            'Ready for second eye (unbooked)' => '/OphCiExamination/report/readyForSecondEyeUnbooked',
        ),
    )
);
