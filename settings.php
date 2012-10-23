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

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) { // only users with this ability can access these settings
    
    $settings = new admin_settingpage('local_yourrecentupdates', get_string('pluginname', 'local_yourrecentupdates'));
    
    $ADMIN->add('localplugins', $settings);
    
    $settings->add(new admin_setting_configtext('notifications_per_page', get_string('notifications_per_page', 'local_yourrecentupdates'),
                                             get_string('notifications_per_page_detail', 'local_yourrecentupdates'), 20, PARAM_INT));
    
    $settings->add(new admin_setting_configtext('max_number_of_notifications', get_string('max_number_of_notifications', 'local_yourrecentupdates'),
                                                get_string('max_number_of_notifications_detail', 'local_yourrecentupdates'), 0, PARAM_INT));
}
