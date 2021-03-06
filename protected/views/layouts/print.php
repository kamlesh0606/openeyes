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
    $printHelperClass = '';
    switch(Yii::app()->controller->module->id){
        case 'OphCoCorrespondence':
            $printHelperClass = 'OphCoCorrespondence large-font';
            break;
        case 'OphTrConsent':
            $printHelperClass = 'OphTrConsent '.(isset($_GET['vi']) && $_GET['vi'] ? 'impaired-vision' : 'large-font');
            break;
    }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?=\CHtml::encode($this->pageTitle); ?></title>
<?php Yii::app()->clientScript->registerCoreScript('jquery')?>
</head>
<body class="open-eyes print <?= $printHelperClass ?>">
	<?php echo $content; ?>
	<script type="text/javascript">
		$(document).ready(function() {

			// function for printing
			printFn = function() {
				window.print();
			};

			// check to see if the eyedraw libraries are loaded (which implies that we have eyedraws
			// on the page) If they are, then use that to call the print function when ready, otherwise
			// we can just call it straight off
			if (typeof(getOEEyeDrawChecker) === 'function') {
				edChecker = getOEEyeDrawChecker();
				edChecker.registerForReady(printFn);
			} else {
				printFn();
			}
		});
	</script>
</body>
</html>
