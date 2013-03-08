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
 * Description: function to show filters for recent updates
 *
 * Author: Daniel J. Somers 15/10/2012
 */
function get_user_notification_filters($course_selected, $update_type)
{       
    $course_select = html_writer::start_tag('form',array('name'=>'frmfilter','method'=>'post'));
    //$course_select .= html_writer::start_tag('div', array('class'=>'filters'));
    
    $course_select .= html_writer::start_tag('div', array('class'=>'tabtree'));
    //$course_select .= html_writer::start_tag('h3');
    //$course_select .= get_string('updatetype', 'local_yourrecentupdates');
    //$course_select .= html_writer::end_tag('h3');
    
    $course_select .= html_writer::start_tag('ul', array('class'=>'tabrow0'));
    
    if($update_type=='0') {
        $course_select .= html_writer::start_tag('li', array('class'=>'all selected'));
    } else {
        $course_select .= html_writer::start_tag('li', array('class'=>'all'));
    }
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=0;document.frmfilter.submit();'));
    $course_select .= html_writer::start_tag('span');
    $course_select .= html_writer::end_tag('span');
    $course_select .= get_string('all', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    if($update_type=='1') {
        $course_select .= html_writer::start_tag('li', array('class'=>'announcements selected'));
    } else {
        $course_select .= html_writer::start_tag('li', array('class'=>'announcements'));
    }
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=1;document.frmfilter.submit();'));
    $course_select .= html_writer::start_tag('span');
    $course_select .= html_writer::end_tag('span');
    //$course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png'));
    $course_select .= get_string('announcements', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    if($update_type=='2') {
        $course_select .= html_writer::start_tag('li', array('class'=>'course-content selected'));
    } else {
        $course_select .= html_writer::start_tag('li', array('class'=>'course-content'));
    }
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=2;document.frmfilter.submit();'));
    $course_select .= html_writer::start_tag('span');
    $course_select .= html_writer::end_tag('span');
    //$course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png'));
    $course_select .= get_string('coursecontent', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');    
    
    if($update_type=='3') {
        $course_select .= html_writer::start_tag('li', array('class'=>'discussions selected'));
    } else {
        $course_select .= html_writer::start_tag('li', array('class'=>'discussions'));
    }
    $course_select .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.filter.value=3;document.frmfilter.submit();'));
    $course_select .= html_writer::start_tag('span');
    $course_select .= html_writer::end_tag('span');
    //$course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_discussions.png'));
    $course_select .= get_string('discussions', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::end_tag('ul');
    $course_select .= html_writer::end_tag('div');
  
    $course_select .= html_writer::start_tag('div', array('class'=>'clearfix'));
    $course_select .= html_writer::end_tag('div');
    
    //$course_select .= html_writer::end_tag('div');
    
    $course_select .= html_writer::start_tag('div', array('class'=>'row'));
    
    $course_select .= html_writer::start_tag('b');
    $course_select .= get_string('updatesfromcourse', 'local_yourrecentupdates') . ' ';
    $course_select .= html_writer::end_tag('b');
   
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
   
    $course_select .= html_writer::end_tag('select') .' ';
   
    $course_select .= html_writer::empty_tag('input',array('type'=>'submit','value'=>get_string('filter', 'local_yourrecentupdates')));
    
    $course_select .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'page'));
    $course_select .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'filter', 'value'=>$update_type));
    
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
function get_recent_updates($course_id, $update_type, $page_num, $limit) {
  
    $recent_updates = '';
    //$recent_updates = html_writer::start_tag('h3');
    //$recent_updates .= get_string('allupdates', 'local_yourrecentupdates');
    //$recent_updates .= html_writer::end_tag('h3');
    
    // get all recent updates
    $updates = get_recent_update_records($course_id, $update_type, $page_num, $limit);
    
    $total_updates = count($updates);
    $total_pages = ceil($total_updates / $limit);
    
    // sort by datetime
    uasort($updates, "sort_recent_updates_by_date");
     
    if($total_pages>1)
    {
        if($page_num==0) {
            $page_num=1;
        }
        
        $recent_updates .= html_writer::start_tag('div', array('class'=>'paging'));
        $recent_updates .= 'Page:&nbsp;&nbsp;';
        
        for($index=1; $index<=$total_pages; $index++)
        {
            if($index==$page_num) {
                $recent_updates .= '&nbsp;' . $index . '&nbsp;';
            } else { 
                $recent_updates .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.page.value='.$index.';document.frmfilter.submit();'));
                $recent_updates .= '&nbsp;' . $index . '&nbsp;';
                $recent_updates .= html_writer::end_tag('a');
            }
        }
        $recent_updates .= html_writer::end_tag('div');
    }
    
    $recent_updates .= html_writer::start_tag('table');
    $recent_updates .= html_writer::start_tag('tbody');
    
    $update_count = 1;
    
    if($page_num<=1) {
        $current_update = 1;
    }else {
        $current_update = ($page_num-1) * $limit+1;
    }
    
    // show notifications
    foreach($updates as $update) { 
        
        if($update_count >= $current_update && $update_count < $current_update+$limit)
        {
            // show whether this update is read/unread
            $recent_updates .= html_writer::start_tag('tr', array('class'=>$update->status));
            
            // if course update
            if($update->update_type==2) {
                $recent_updates .= html_writer::start_tag('td', array('class'=>'image'));
                $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png','alt'=>''));
                $recent_updates .= html_writer::end_tag('td');
                $recent_updates .= html_writer::start_tag('td', array('class'=>'resource'));
                //$recent_updates .= html_writer::end_tag('td');
            }
            
            // if announcement
            if($update->update_type==1) {
                $recent_updates .= html_writer::start_tag('td', array('class'=>'image'));
                $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png','alt'=>''));
                $recent_updates .= html_writer::end_tag('td');
                //$recent_updates .= html_writer::end_tag('td');
                $recent_updates .= html_writer::start_tag('td', array('class'=>'announcement'));
            }
            
            // if discussion
            if($update->update_type==3) {
                $recent_updates .= html_writer::start_tag('td', array('class'=>'image'));
                $recent_updates .= html_writer::empty_tag('img', array('src'=>'pix/icon_discussions.png','alt'=>''));
                $recent_updates .= html_writer::end_tag('td');
                //$recent_updates .= html_writer::end_tag('td');
                $recent_updates .= html_writer::start_tag('td', array('class'=>'comment'));
            }
            
            // for course
            //$recent_updates .= html_writer::start_tag('td', array('class'=>'course'));
            $recent_updates .= ' '.$update->course. '<br>';
            //$recent_updates .= html_writer::end_tag('td');
            
            // update text
            //$recent_updates .= html_writer::start_tag('td');
            $recent_updates .= ' '.$update->update_text; 
            //$recent_updates .= html_writer::end_tag('td');
        
            
            
            $recent_updates .= html_writer::end_tag('td');
            
            // time/date
            $recent_updates .= html_writer::start_tag('td', array('class'=>'time'));
            $recent_updates .= $update->date_time;
            $recent_updates .= html_writer::end_tag('td');        
    
            $recent_updates .= html_writer::end_tag('tr');
            
            $update_count++;
        }
        else {
            $update_count++;
        }
    }            
    
    $recent_updates .= html_writer::end_tag('tbody');
    $recent_updates .= html_writer::end_tag('table');
    
    if($total_pages>1)
    {
        if($page_num==0) {
            $page_num=1;
        }
        
        $recent_updates .= html_writer::start_tag('div', array('class'=>'paging'));
        $recent_updates .= 'Page:&nbsp;&nbsp;';
        
        for($index=1; $index<=$total_pages; $index++)
        {
            if($index==$page_num) {
                $recent_updates .= '&nbsp;' . $index . '&nbsp;';
            } else { 
                $recent_updates .= html_writer::start_tag('a', array('href'=>'#','onClick'=>'document.frmfilter.page.value='.$index.';document.frmfilter.submit();'));
                $recent_updates .= '&nbsp;' . $index . '&nbsp;';
                $recent_updates .= html_writer::end_tag('a');
            }
        }
        $recent_updates .= html_writer::end_tag('div');
    }
    
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
function get_recent_update_records($course_id, $update_type, $page_num, $limit) {

    global $CFG, $USER, $DB;
    
    // get configuration settings
    $max_number_of_notifications = $CFG->max_number_of_notifications;
    
    $recent_updates = array();
    
    // update type required is all, or latest news (announcements)
    if($update_type==0 || $update_type==1) {
        
        // get users enrolled courses
        $courses = enrol_get_my_courses(NULL, 'visible DESC');
        
        foreach($courses as $course)
        {
            
            require_once($CFG->dirroot.'/mod/forum/lib.php');
            
            $course_forum_id=0;
            
            if($course_id!=0) {
                $course_forum_id=$course_id;
            } else {
                $course_forum_id=$course->id;
            }
            
            // get news for each course
            if ($announcements = forum_get_course_forum($course_forum_id, 'news')) {
                
                // if filtered on a course
                if($course_id!=0) {
                    $current_course = $DB->get_record('course', array('id'=>$course_id));
                } else {
                    $current_course = $DB->get_record('course', array('id'=>$course->id));
                }
                
                $modinfo = get_fast_modinfo($current_course);
                
                if ($modinfo->instances['forum'][$announcements->id]) {

                    $cm = $modinfo->instances['forum'][$announcements->id];

                    if ($cm->uservisible) {
                        $context = get_context_instance(CONTEXT_MODULE, $cm->id);

                        if (has_capability('mod/forum:viewdiscussion', $context)) {
                            
                            $log_entry_viewed = 'unread';
                            $log_entry_url = $CFG->wwwroot.'/mod/forum/view.php?id='.$announcements->id;
                    
                            // check if the user has viewed the update
                            if($DB->get_record_select('log', "userid = ? AND module = 'forum' AND course = ? AND cmid = ? AND (action = 'view forum') LIMIT 1", array($USER->id, $course_forum_id, $announcements->id))) {
                                // mark this log entry as viewed
                                $log_entry_viewed = 'read';
                            }
              
                            // get course name
                            $log_entry_course_name = html_writer::start_tag('a', array('class'=>'updates-course', 'href'=>$log_entry_url));
                            $log_entry_course_name .= $current_course->fullname;
                            $log_entry_course_name .= html_writer::end_tag('a');
                                                                            
                            // prepare update text
                            $log_entry_update_text = html_writer::start_tag('a', array('class'=>'updates-text', 'href'=>$log_entry_url));
                            $log_entry_update_text .= format_string($cm->name, true);
                            $log_entry_update_text .= ' - ' .$announcements->intro;                            
                            $log_entry_update_text .= html_writer::end_tag('a');
                        
                            // get time of update
                            //$log_entry_time_created = date('l jS F Y', $announcements->timemodified);
                            $log_entry_time_created = date('l j/m/y', $announcements->timemodified);
                            $log_datetime_compare = $announcements->timemodified;
                            
                            // store log entries
                            $recent_update = new stdClass();
                            $recent_update->id = $announcements->id;
                            $recent_update->course = $log_entry_course_name;
                            $recent_update->update_text = $log_entry_update_text;
                            $recent_update->date_time = $log_entry_time_created;
                            $recent_update->status = $log_entry_viewed;
                            
                            // check what the this update type is
                            $recent_update->update_type = 1;
        
                            $recent_update->order_by = $log_datetime_compare;
                            
                            // add this update to the recent updates array
                            $recent_updates[]=$recent_update;                    
                        }        
                    }
                }
            }
        }
    }
        
    // update type required is all, or course content
    if($update_type==0 || $update_type==2) {
    
        // get added course modules
        if($course_id!=0)
        {
            $logs = $DB->get_records_select('log', "module = 'course' AND (course = ?) AND (action = 'add mod')", array($course_id), "id DESC");
        }else {
            
            // get users enrolled courses
            $courses = enrol_get_my_courses(NULL, 'visible DESC');
            
            foreach($courses as $course) {
                $logs = $DB->get_records_select('log', "module = 'course' AND (action = 'add mod') AND course=$course->id", null, "id DESC");
            }
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
                    $log_entry_course_name = html_writer::start_tag('a', array('class'=>'updates-course','href'=>$CFG->wwwroot.$log_entry_url));
                    $log_entry_course_name .= $log_entry_course->fullname;
                    $log_entry_course_name .= html_writer::end_tag('a');
                                                                    
                    // prepare update text
                    $log_entry_update_text = html_writer::start_tag('a', array('class'=>'updates-text','href'=>$CFG->wwwroot.$log_entry_url));
                    $log_entry_update_text .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                    $stradded = get_string('added', 'moodle', get_string('modulename', $modname));
                    $log_entry_update_text .= $stradded . ' ' . format_string($cm->name, true);
                    $log_entry_update_text .= html_writer::end_tag('a');
                
                    // get time of update
                    $log_entry_time_created = date('l j/m/y', $log->time);
                    //$log_entry_time_created = date('l jS F Y', $log->time);
                    $log_datetime_compare = $log->time;
                    
                    // store log entries
                    $recent_update = new stdClass();
                    $recent_update->id = $log->id;
                    $recent_update->course = $log_entry_course_name;
                    $recent_update->update_text = $log_entry_update_text;
                    $recent_update->date_time = $log_entry_time_created;
                    $recent_update->status = $log_entry_viewed;
                    
                    // check what the this update type is
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
            
            // get users enrolled courses
            $courses = enrol_get_my_courses(NULL, 'visible DESC');
            
            foreach($courses as $course) {
                $logs = $DB->get_records_select('log', "module = 'forum' AND course = $course->id AND (action = 'add discussion' || action = 'add post')", null, "id DESC");
            }
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
                $log_entry_course_name = html_writer::start_tag('a', array('class'=>'updates-course', 'href'=>$CFG->wwwroot.'/mod/forum/'.$log_entry_url));
                $log_entry_course_name .= $log_entry_course->fullname;
                $log_entry_course_name .= html_writer::end_tag('a');
                                                                
                // prepare update text
                $log_entry_update_text = html_writer::start_tag('a', array('class'=>'updates-text','href'=>$CFG->wwwroot.'/mod/forum/'.$log_entry_url));
                $log_entry_update_text .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                $stradded = get_string('added', 'moodle', get_string('modulename', 'forum'));
                $log_entry_update_text .= $stradded . ' ' . $log_entry_name;
                $log_entry_update_text .= html_writer::end_tag('a');
                
                // get time of update
                $log_entry_time_created = date('l j/m/y', $log->time);
                //$log_entry_time_created = date('l jS F Y', $log->time);
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
    
    // is maximum number of notifications limited ?
    if($max_number_of_notifications>0)
    {
        $recent_updates = array_slice($recent_updates, 0, $max_number_of_notifications);
    }
    
    return $recent_updates;
}


/**
 * Description: function to sort an array based on the value of
 *              the index order_by (unix timestamp/numeric)
 *
 * Author: Daniel J. Somers 22-10-2012
 */
function sort_recent_updates_by_date($recent_update_1, $recent_update_2)
{
    if ( $recent_update_1->order_by > $recent_update_2->order_by ) return -1;
    
    if ( $recent_update_1->order_by < $recent_update_2->order_by ) return 1;
    
    return 0; 
}

