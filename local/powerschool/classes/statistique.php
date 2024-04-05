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
 * 
 */

namespace local_powerschool;

use Exception;
use moodleform;
use stdClass;


require_once($CFG->libdir.'/formslib.php');

class statistique {

    /**
     * retourne le nombre d'element d'un table mis en parametre
     */
    public function get_number_ofEtudiant(string $table):int{
        global $DB;

        $sql = "SELECT COUNT(id) FROM {inscription} i, {users} u WHERE i.idetudiant = u.id AND i.idcampus" ;

        $req = $DB->get_records_sql($sql);

        return $req;
    }


    /**
     * retourne le liste des etudiants en fonction des specialités cycles
     */
    public function get_EtudiantByspecialite(int $user, int $specialite, int $cycle){
        global $DB;

        $sql = "SELECT * FROM {users} u, {specialite} s, {cycle} c ,{inscription} i WHERE i.idspecialite = s.id AND i.idcycle = c.id 
                AND i.idetudiant = u.id AND i.idspecialite = $specialite AND i.cycle = $cycle ;";

        $req = $DB->get_records_sql($sql);

        return $req;
    }


    /**
     * Retourne la liste des etudiant inscrit dans un campus durant un annee scolaire
     */
    public function get_EtudiantCampus(int $user,int $campus,int $anneescolaire){
        global $DB;

        $sql = "SELECT * FROM {campus} c, {users} u, {anneescolaire} a, {inscription} i WHERE i.idetudiant = u.id AND i.idanneescolaire = a.id 
                AND i.idcampus = c.id AND i.idetudiant = $user AND i.campus = $campus AND i.anneescolaire = $anneescolaire ;";

        $req = $DB->get_records_sql($sql);

        return $req;
    }


}