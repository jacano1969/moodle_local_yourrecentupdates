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


/**
 * lib functions for your recent updates local plugin
 */


/**
 * Description: function to show filters for recent updates
 *
 * Author: Daniel J. Somers 15/10/2012
 */
function get_user_notification_filters($course_selected)
{       
    $course_select = html_writer::start_tag('form',array('name'=>'frmfilter','method'=>'post'));
    $course_select .= html_writer::start_tag('div', array('class'=>'filters'));
    
    $course_select .= html_writer::start_tag('div', array('class'=>'row'));
    
    $course_select .= html_writer::start_tag('h3',array('for'=>'course'));
    $course_select .= get_string('updatesfromcourse', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('h3');
   
    $course_select .= html_writer::start_tag('p');   
   
    $course_select .= html_writer::start_tag('select',array('name'=>'course'));
   
    $course_select .= html_writer::start_tag('option',array('value'=>0));
    $course_select .= get_string('all', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('option');
   
    if ($courses = enrol_get_my_courses(NULL, 'visible DESC, fullname ASC')) {
        
        foreach ($courses as $course) {
            
            if($course_selected==$course->id){
                $course_select .= html_writer::start_tag('option',array('selected'=>'selected','value'=>$course->id));
            }else{
                $course_select .= html_writer::start_tag('option',array('value'=>$course->id));
            }
            
            $course_select .= format_string($course->fullname);
            $course_select .= html_writer::end_tag('option');
        }
    }
   
    $course_select .= html_writer::end_tag('select');
   
    $course_select .= html_writer::empty_tag('input',array('type'=>'submit','value'=>get_string('filter', 'local_yourrecentupdates')));
    
    $course_select .= html_writer::empty_tag('input',array('type'=>'hidden','name'=>'filter'));
    
    $course_select .= html_writer::end_tag('p');  
    $course_select .= html_writer::end_tag('div');
    
    $course_select .= html_writer::start_tag('div', array('class'=>'row'));
    $course_select .= html_writer::start_tag('h3');
    $course_select .= get_string('updatetype', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('h3');
    
    $course_select .= html_writer::start_tag('ul');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=0;document.frmfilter.submit();'));
    $course_select .= get_string('all', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=1;document.frmfilter.submit();'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png'));
    $course_select .= get_string('announcements', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=2;document.frmfilter.submit();'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png'));
    $course_select .= get_string('coursecontent', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');    
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=3;document.frmfilter.submit();'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_discussions.png'));
    $course_select .= get_string('discussions', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::end_tag('ul');
    $course_select .= html_writer::end_tag('div');
  
    $course_select .= html_writer::start_tag('div', array('class'=>'clearfix'));
    $course_select .= html_writer::end_tag('div');
    
    $course_select .= html_writer::end_tag('div');
    $course_select .= html_writer::end_tag('form');

    return $course_select;
}


/**
 * Description: function to get a list of recent updates
 *              given the update type
 *
 * Author: Daniel J. Somers 15/10/2910
 */
function get_recent_updates($course_id, $update_type) {
  
    $recent_updates = html_writer::start_tag('h3');
    $recent_updates .= get_string('allupdates', 'local_yourrecentupdates');
    $recent_updates .= html_writer::end_tag('h3');
    
    $recent_updates .= html_writer::start_tag('table');
    $recent_updates .= html_writer::start_tag('tbody');
    
    
    // get all recent updates
    $updates = get_recent_update_records($course_id, $update_type);
    
    // sort by datetime
    uasort($updates, "sort_recent_updates_by_date");
    
    foreach($updates as $update) {
                    
        // show whether this update is read/unread
        $recent_updates .= html_writer::start_tag('tr', array('class'=>$update->status));
        
        // if course update
        if($update->update_type==2) {
            $recent_updates .= html_writer::start_tag('td', array('class'=>'resource'));
            $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png','alt'=>''));
            $recent_updates .= html_writer::end_tag('td');
        }
        
        // if announcement
        if($update->update_type==1) {
            $recent_updates .= html_writer::start_tag('td', array('class'=>'announcement'));
            $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png','alt'=>''));
            $recent_updates .= html_writer::end_tag('td');
        }
        
        // if discussion
        if($update->update_type==3) {
            $recent_updates .= html_writer::start_tag('td', array('class'=>'comment'));
            $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_discussions.png','alt'=>''));
            $recent_updates .= html_writer::end_tag('td');
        }
        
        // update text
        $recent_updates .= html_writer::start_tag('td');
        #$recent_updates .= html_writer::start_tag('a', array('href'=>'#'));
        $recent_updates .= $update->update_text;
        #$recent_updates .= html_writer::end_tag('a');
        $recent_updates .= html_writer::end_tag('td');
    
        // for course
        $recent_updates .= html_writer::start_tag('td', array('class'=>'course'));
        #$recent_updates .= html_writer::start_tag('a', array('href'=>'#'));
        $recent_updates .= $update->course;
        #$recent_updates .= html_writer::end_tag('a');
        $recent_updates .= html_writer::end_tag('td');
        
        // time/date
        $recent_updates .= html_writer::start_tag('td', array('class'=>'time'));
        $recent_updates .= $update->date_time;
        $recent_updates .= html_writer::end_tag('td');        

        $recent_updates .= html_writer::end_tag('tr');
    }            
    
    $recent_updates .= html_writer::end_tag('tbody');
    $recent_updates .= html_writer::end_tag('table');
    
    return $recent_updates;
}



/**
 * Helper functions
 */

 /**
  * Description: function to retreive notifications given the notification type
  *
  * Author: Daniel J. Somers 15/10/2012
  */
function get_recent_update_records($course_id, $update_type) {

    global $CFG, $USER, $DB;

    $recent_updates = array();
    
    // update type required is all, announcement, or course content
    if($update_type==0 || $update_type==1 || $update_type==2) {
    
        // get added course modules
        if($course_id!=0)
        {
            $logs = $DB->get_records_select('log', "module = 'course' AND (course = ?) AND (action = 'add mod')", array($course_id), "id DESC");
        }else {
            $logs = $DB->get_records_select('log', "module = 'course' AND (action = 'add mod')", null, "id DESC");
        }
        
        if($logs) {
            
            foreach ($logs as $key => $log) {
                
                $info = explode(' ', $log->info);
                
                if ($info[0] == 'label') {     // Labels are ignored in recent activity
                    continue;
                }
                
                if (count($info) != 2) {
                    debugging("Incorrect log entry info: id = ".$log->id, DEBUG_DEVELOPER);
                    continue;
                }
                
                // get course details for log entry
                $context = get_context_instance(CONTEXT_COURSE, $log->course);
                $course = $DB->get_record('course', array('id'=>$log->course));
                
                // Next, have there been any modifications to the course structure?
                $modinfo = get_fast_modinfo($course);
        
                $modname    = $info[0];
                $instanceid = $info[1];
                
                if($log->action=='add mod') {
                
                    // check that this mod still exists (may have been removed)
                    if(!isset($modinfo->instances[$modname][$instanceid])) {
                        continue;
                    }
                    
                    // get mod info
                    $cm = $modinfo->instances[$modname][$instanceid];
                    
                    // check if user has access
                    if (!$cm->uservisible) {
                        continue;
                    }
                    
                    // url action to view log entry
                    $log_entry_url = str_replace('..','',$log->url);
                    
                    $log_entry_viewed = 'unread';
                    
                    // check if the user has viewed the update
                    if($DB->get_record_select('log', "userid = ? AND module = ? AND (action = 'view' || action = 'view forum') LIMIT 1", array($USER->id, $modname))) {
                        // mark this log entry as viewed
                        $log_entry_viewed = 'read';
                    }
                    
                    // get user record for this update
                    $log_entry_user = $DB->get_record('user', array('id'=>$log->userid));
      
                    // get course name
                    $log_entry_course = $DB->get_record('course',array('id'=>$cm->course));
                    $log_entry_course_name = html_writer::start_tag('a', array('href'=>$CFG->wwwroot.$log_entry_url));
                    $log_entry_course_name .= $log_entry_course->fullname;
                    $log_entry_course_name .= html_writer::end_tag('a');
                                                                    
                    // prepare update text
                    $log_entry_update_text = html_writer::start_tag('a', array('href'=>$CFG->wwwroot.$log_entry_url));
                    $log_entry_update_text .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                    $stradded = get_string('added', 'moodle', get_string('modulename', $modname));
                    $log_entry_update_text .= $stradded . ' ' . format_string($cm->name, true);
                    $log_entry_update_text .= html_writer::end_tag('a');
                
                    // get time of update
                    $log_entry_time_created = date('l jS F Y', $log->time);
                    $log_datetime_compare = $log->time;
                    
                    // store log entries
                    $recent_update = new stdClass();
                    $recent_update->id = $log->id;
                    $recent_update->course = $log_entry_course_name;
                    $recent_update->update_text = $log_entry_update_text;
                    $recent_update->date_time = $log_entry_time_created;
                    $recent_update->status = $log_entry_viewed;
                    $recent_update->update_type = 2;
                    $recent_update->order_by = $log_datetime_compare;
                    
                    // add this update to the recent updates array
                    $recent_updates[]=$recent_update;
                }
            }
        }    
    }
    
    if($update_type==0 || $update_type==3) {
        
        // get added forum discussions
        if($course_id!=0)
        {
            $logs = $DB->get_records_select('log', "module = 'forum' AND (course = ?) AND (action = 'add discussion' || action = 'add post')", array($course_id), "id DESC");
        } else {
            $logs = $DB->get_records_select('log', "module = 'forum' AND (action = 'add discussion' || action = 'add post')", null, "id DESC");
        }
        
        if($logs) {
           
            foreach ($logs as $key => $log) {
                    
                // url action to view log entry
                $log_entry_url = str_replace('..','',$log->url);
                $log_entry_name = str_replace('add','',$log->action);
                
                $log_entry_viewed = 'unread';
                
                // check if the user has viewed the update
                if($DB->get_record_select('log', "userid = ? AND module = 'forum' AND (action = 'view forum' || action = 'view discussion') LIMIT 1", array($USER->id))) {
                    // mark this log entry as viewed
                    $log_entry_viewed = 'read';
                }
                
                // get user record for this update
                $log_entry_user = $DB->get_record('user', array('id'=>$log->userid));
  
                // get course name
                $log_entry_course = $DB->get_record('course',array('id'=>$log->course));
                $log_entry_course_name = html_writer::start_tag('a', array('href'=>$CFG->wwwroot.'/mod/forum/'.$log_entry_url));
                $log_entry_course_name .= $log_entry_course->fullname;
                $log_entry_course_name .= html_writer::end_tag('a');
                                                                
                // prepare update text
                $log_entry_update_text = html_writer::start_tag('a', array('href'=>$CFG->wwwroot.'/mod/forum/'.$log_entry_url));
                $log_entry_update_text .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                $stradded = get_string('added', 'moodle', get_string('modulename', 'forum'));
                $log_entry_update_text .= $stradded . ' ' . $log_entry_name;
                $log_entry_update_text .= html_writer::end_tag('a');
                
                // get time of update
                $log_entry_time_created = date('l jS F Y', $log->time);
                $log_datetime_compare = $log->time;
                
                // store log entries
                $recent_update = new stdClass();
                $recent_update->id = $log->id;
                $recent_update->course = $log_entry_course_name;
                $recent_update->update_text = $log_entry_update_text;
                $recent_update->date_time = $log_entry_time_created;
                $recent_update->status = $log_entry_viewed;
                $recent_update->update_type = 3;
                $recent_update->order_by = $log_datetime_compare;
                
                // add this update to the recent updates array
                $recent_updates[]=$recent_update;
            }
        }    
    }
    
    return $recent_updates;
}



function sort_recent_updates_by_date($recent_update_1, $recent_update_2)
{
    if ( $recent_update_1->order_by > $recent_update_2->order_by ) return -1;
    
    if ( $recent_update_1->order_by < $recent_update_2->order_by ) return 1;
    
    return 0; 
}




/*  still to implement
<div class="pagination">
  
  <p>Page 2 of 14</p>

  <ul>
    <li><a href="">1</a></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href="">4</a></li>
    <li><a href="">&hellip;</a></li>
    <li><a href="">14</a></li>
    <li class="next"><a href="">Next<span></span></a></li>
    <li class="last"><a href="">Last<span></span></a></li>                
  </ul>
  
  <div class="clearfix"></div>  
              
</div><!-- /.pagination -->

*/