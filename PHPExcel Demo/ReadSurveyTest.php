<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.5, 2010-12-10
 */

/** Error reporting */
error_reporting(E_ALL);

//date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once '/libraries/PHPExcel/IOFactory.php';

if (!file_exists("Experiment A.xlsx")) {
	exit("Experiment A.xlsx does not exist.\n");
}

echo date('H:i:s') . " Load from Excel2007 file\n";
$objPHPExcel = PHPExcel_IOFactory::load("Experiment A.xlsx");
$objPHPExcel->setActiveSheetIndex(0);
echo "<br/>";
echo "<br/>";
echo "<table border='3'>";
echo "<tr><td>Cell B2 (Questions per Page)</td><td>".$objPHPExcel->getActiveSheet()->GetCell('B7')->getCalculatedValue()."</td></tr>";
echo "<tr><td>Cell C1 (Width)</td><td>".$objPHPExcel->getActiveSheet()->GetCell('B8')->getCalculatedValue()."</td></tr>";
echo "<tr><td>Cell D2 (Header Left Title)</td><td>".$objPHPExcel->getActiveSheet()->GetCell('B16')->getCalculatedValue()."</td></tr>";
echo "</table>";
echo "<br/>";

// Echo memory peak usage
echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
echo date('H:i:s') . " Done reading file.\r\n";

?>