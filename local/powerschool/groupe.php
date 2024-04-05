<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\inscription;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

// require_once($CFG->dirroot.'/local/powerschool/classes/inscription.php');
// require_once('tcpdf/tcpdf.php');

global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/groupe.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('inscription de Cours');
$PAGE->set_heading('inscription de Cours');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new inscription();

function groupee ($id,$depth=0){
    global $DB;
    // $sql="SELECT * FROM {course_categories} WHERE depth='".$depth."' AND depth>=(SELECT depth FROM {course_categories})";
    // $sql="SELECT * FROM {course_categories} WHERE depth='".$depth."' AND depth > 
    //       (SELECT depth FROM {course_categories})";
    //  $daphsql=$DB->get_recordset_sql($sql);


    //  return $daphsql;
}
// $groupe= new groupe;

// var_dump(groupee(1,1));



