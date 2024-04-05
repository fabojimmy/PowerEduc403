<?php
//fichier de definittion des liens de configuration

// if($hassiteconfig) {
       $ADMIN->add('root',new admin_category('powerschool', 'PowerEduc'));

 
        $ADMIN->add('powerschool', new admin_externalpage('index', get_string('reglages', 'local_powerschool'), 
        new moodle_url ('/local/powerschool/statistique.php')));
        $ADMIN->add('powerschool', new admin_externalpage('index', get_string('campus', 'local_powerschool'), 
        new moodle_url ('/local/powerschool/campusdebut.php')));



