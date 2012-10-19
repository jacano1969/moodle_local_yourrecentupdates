<?php
// This file is part of Moodle - http://moodle.org/
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

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/yourrecentupdates/lib.php');

require_login(0, false);

$course_id = optional_param('course', 0, PARAM_INT);  // show recent updates based on course
$update_type = optional_param('filter', 0, PARAM_INT);         // show all updates|announcements|course content|discussions


$PAGE->set_url('/local/yourrecentupdates/');
$context = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_yourrecentupdates'));

$PAGE->navbar->add(get_string('pluginname', 'local_yourrecentupdates'));

$recent_updates='';

$recent_updates .= $OUTPUT->header();
$recent_updates .= $OUTPUT->heading(get_string('pluginname', 'local_yourrecentupdates'));

$recent_updates .= html_writer::start_tag('div', array('class'=>'in-page-controls'));
$recent_updates .= html_writer::start_tag('p', array('class='=>'settings'));
$recent_updates .= html_writer::start_tag('a', array('href'=>'#'));
$recent_updates .= get_string('settings', 'local_yourrecentupdates');
$recent_updates .= html_writer::start_tag('span');
$recent_updates .= html_writer::start_tag('i');
$recent_updates .= html_writer::end_tag('i');
$recent_updates .= html_writer::end_tag('i');
$recent_updates .= html_writer::end_tag('a');
$recent_updates .= html_writer::end_tag('p');
$recent_updates .= html_writer::end_tag('div');
            
// TESTING !!!
//$recent_updates .= var_dump($_POST);

$recent_updates .= get_user_notification_filters($course_id);



$testing = get_recent_updates($course_id, $update_type);

$recent_updates .= html_writer::start_tag('h4');
$recent_updates .= $testing;
$recent_updates .= html_writer::end_tag('h4');




$recent_updates .= $OUTPUT->footer();

echo $recent_updates;

