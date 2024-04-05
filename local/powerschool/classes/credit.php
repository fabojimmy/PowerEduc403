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

namespace local_powerschool;
use stdClass;
use moodleform;
use local_powerschool\campus;
// use local_powerschool\id;


require_once($CFG->libdir.'/formslib.php');

class credit extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse;
        
        global $USER;
        $mform = $this->_form;
        $mform->addElement('text', 'credit',"Credit ou Coef"); // Add elements to your form
        $mform->setType('credit', PARAM_INT);                   //Set type of element
        $mform->setDefault('credit', 0);        //Default value
        $mform->addRule('credit', 'Entrer le credit', 'required');
        $mform->addHelpButton('credit', 'Credit');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value
        
        $mform->addElement('hidden', 'idspco'); // Add elements to your form
        $mform->setType('idspco', PARAM_INT);                   //Set type of element
        $mform->setDefault('idspco', $_GET["idspco"]);        //Default value

        $mform->addElement('hidden', 'idcampus'); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus', $_GET["idca"]);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

        $mform->addElement('hidden', 'idcampus', 'date de modification'); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus',ChangerSchoolUser($USER->id));        //Default value

       

        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }


}