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
   
    $course_select .= html_writer::end_tag('p');  
    $course_select .= html_writer::end_tag('div');
    
    $course_select .= html_writer::start_tag('div', array('class'=>'row'));
    $course_select .= html_writer::start_tag('h3');
    $course_select .= get_string('updatetype', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('h3');
    
    $course_select .= html_writer::start_tag('ul');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= get_string('all', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png'));
    $course_select .= get_string('announcements', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png'));
    $course_select .= get_string('coursecontent', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('a');
    $course_select .= html_writer::end_tag('li');    
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
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
function get_recent_updates($update_type) {
  
    $recent_updates = html_writer::start_tag('h3');
    $recent_updates .= get_string('allupdates', 'local_yourrecentupdates');
    $recent_updates .= html_writer::end_tag('h3');
    
    $recent_updates .= html_writer::start_tag('table');
    $recent_updates .= html_writer::start_tag('tbody');
    
    
    // get all recent updates
    $updates = get_recent_update_records($update_type);
    
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
        $recent_updates .= html_writer::start_tag('a', array('href'=>'#'));
        $recent_updates .= $update->update_text;
        $recent_updates .= html_writer::end_tag('a');
        $recent_updates .= html_writer::end_tag('td');
    
        // for course
        $recent_updates .= html_writer::start_tag('td', array('class'=>'course'));
        $recent_updates .= html_writer::start_tag('a', array('href'=>'#'));
        $recent_updates .= $update->course;
        $recent_updates .= html_writer::end_tag('a');
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

function get_recent_update_records($update_type) {

    global $CFG, $USER, $DB, $OUTPUT;

    $recent_updates = array();
    
    // update type required is all, announcement, or course content
    if($update_type==0 || $update_type==1 || $update_type==2) {
    
        // get added course modules
        $logs = $DB->get_records_select('log', "module = 'course' AND (action = 'add mod')", null, "id ASC");
    
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
                
                $context = get_context_instance(CONTEXT_COURSE, $log->course);
                $course = $DB->get_record('course', array('id'=>$log->course));
                
                // Next, have there been any modifications to the course structure?
                $modinfo = get_fast_modinfo($course);
        
                $modname    = $info[0];
                $instanceid = $info[1];
                
                if($log->action=='add mod') {
                
                    if(!$info[0] || !$info[1]) {
                        continue;
                    }
                    
                    $cm = $modinfo->instances[$modname][$instanceid];
                    
                    // check if user has access
                    if (!$cm || !$cm->uservisible) {
                        continue;
                    }
                    
                    // url action to view log entry
                    $log_entry_url = str_replace('..','',$log->url);
                    
                    $log_entry_viewed = 'unread';
                    
                    // check if the user has viewed the update
                    if($DB->get_record_select('log', "userid = ? AND module = ? AND action = 'view' LIMIT 1", array($USER->id, $modname))) {
                        // mark this log entry as viewed
                        $log_entry_viewed = 'read';
                    }
                    
                    // get user record for this update
                    $log_entry_user = $DB->get_record('user', array('id'=>$log->userid));
      
                    // get course name              
                    $log_entry_course = $DB->get_record('course',array('id'=>$cm->course));
                    $log_entry_course_name = $log_entry_course->fullname;
                    
                    // prepare update text
                    $log_entry_update_text = html_writer::start_tag('a', array('href'=>$CFG->wwwroot.$log_entry_url));
                    $log_entry_update_text .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                    $stradded = get_string('added', 'moodle', get_string('modulename', $modname));
                    $log_entry_update_text .= $stradded . ' ' . format_string($cm->name, true);
                
                    // get time of update
                    $log_entry_time_created = date('l jS F Y', $log->time);
                    
                    // store log entries
                    $recent_update = new stdClass();
                    $recent_update->id = $log->id;
                    $recent_update->course = $log_entry_course_name;
                    $recent_update->update_text = $log_entry_update_text;
                    $recent_update->date_time = $log_entry_time_created;
                    $recent_update->status = $log_entry_viewed;
                    $recent_update->update_type = 2;
                    
                    // add this update to the recent updates array
                    $recent_updates[]=$recent_update;
                }
            }
        }    
    }
    
    //
    // work in progress !!!!
    //
    
    // only get recent posts if the limit has not been reached
    /*if($num_notifications<$limit) {
        
        // calculate new limit
        $newlimit = $limit-$num_notifications;
        
        // get forum posts
        $posts = $DB->get_records_sql("SELECT p.*, f.type AS forumtype, d.forum, d.groupid,
                                                  d.timestart, d.timeend, d.userid AS duserid,
                                                  u.firstname, u.lastname, u.email, u.picture
                                             FROM {forum_posts} p
                                                  JOIN {forum_discussions} d ON d.id = p.discussion
                                                  JOIN {forum} f             ON f.id = d.forum
                                                  JOIN {user} u              ON u.id = p.userid
                                            WHERE p.created > ? AND f.course = ?
                                         ORDER BY p.id ASC LIMIT $newlimit", array($timestart, $course->id)); // order by initial posting date
        
        if($posts) {
            
            foreach ($posts as $post) {
                if (!isset($modinfo->instances['forum'][$post->forum])) {
                    // not visible
                    continue;
                }
                $cm = $modinfo->instances['forum'][$post->forum];
                if (!$cm->uservisible) {
                    continue;
                }
                $context = get_context_instance(CONTEXT_MODULE, $cm->id);
        
                if (!has_capability('mod/forum:viewdiscussion', $context)) {
                    continue;
                }
        
                if (!empty($CFG->forum_enabletimedposts) and $USER->id != $post->duserid
                  and (($post->timestart > 0 and $post->timestart > time()) or ($post->timeend > 0 and $post->timeend < time()))) {
                    if (!has_capability('mod/forum:viewhiddentimedposts', $context)) {
                        continue;
                    }
                }
        
                $groupmode = groups_get_activity_groupmode($cm, $course);
        
                if ($groupmode) {
                    if ($post->groupid == -1 or $groupmode == VISIBLEGROUPS or has_capability('moodle/site:accessallgroups', $context)) {
                        // oki (Open discussions have groupid -1)
                    } else {
                        // separate mode
                        if (isguestuser()) {
                            // shortcut
                            continue;
                        }
        
                        if (is_null($modinfo->groups)) {
                            $modinfo->groups = groups_get_user_groups($course->id); // load all my groups and cache it in modinfo
                        }
        
                        if (!array_key_exists($post->groupid, $modinfo->groups[0])) {
                            continue;
                        }
                    }
                }
        
                // get user profile pic
                $log_entry_user = $DB->get_record('user', array('id'=>$post->userid));
                $log_entry_user_profile_pic = $OUTPUT->user_picture($log_entry_user, array('size'=>60));
                
                // get course name              
                $log_entry_course = $DB->get_record('course',array('id'=>$course->id));
                $log_entry_course_name = $log_entry_course->fullname;
                    
                $notifications .= html_writer::start_tag('li');
                $notifications .= $log_entry_user_profile_pic;
                $notifications .= html_writer::start_tag('h5');
                $notifications .= html_writer::start_tag('a', array('href'=>'#'));
                $notifications .= $log_entry_course_name;
                $notifications .= html_writer::end_tag('a');
                $notifications .= html_writer::end_tag('h5');
                $notifications .= html_writer::start_tag('p');
                
                if (empty($post->parent)) {
                    $notifications .= html_writer::start_tag('a', array('href'=>$CFG->wwwroot.'/mod/forum/discuss.php?d='.$post->discussion));
                } else {
                    $notifications .= html_writer::start_tag('a', array('href'=>$CFG->wwwroot.'/mod/forum/discuss.php?d='.$post->discussion.'&amp;parent='
                                                            .$post->parent.'#p'.$post->id));
                }
                
                $notifications .= html_writer::start_tag('a', array('href'=>$CFG->wwwroot.'/mod/'.$cm->modname.'/view.php?id='.$cm->id));
                $notifications .= $log_entry_user->firstname . ' ' .$log_entry_user->lastname.': ';
                $notifications .= get_string('newforumposts', 'forum'). ' ';
                $notifications .= break_up_long_words(format_string($post->subject, true)).' ';
                $notifications .= format_string($cm->name, true);
                $notifications .= html_writer::end_tag('a');
                $notifications .= html_writer::end_tag('p');
                $notifications .= html_writer::start_tag('p', array('class'=>'time'));
                $notifications .= date('l jS F Y', $post->modified);
                $notifications .= html_writer::end_tag('p');
                $notifications .= html_writer::end_tag('li');
                
                $num_notifications++;
            }
        }
    }
    
    $all_notifications = get_string('recentupdates','theme_ual', $num_notifications);
    $all_notifications .= html_writer::end_tag('a');
    $all_notifications .= html_writer::end_tag('h4');
    $all_notifications .= html_writer::start_tag('div');
    $all_notifications .= html_writer::start_tag('ol');
    
    $all_notifications .= $notifications;
    
    $all_notifications .= html_writer::end_tag('ol');    */
    
    return $recent_updates;
}

/*
<h2>All updates</h2>

<table>
  <tbody>
    <tr class="unread">
      <td class="resource"><img src="pix/icon_coursecontent.png" alt=""></td>
      <td><a href="">John Doe: Resource tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr class="unread">
      <td class="announcement"><img src="pix/icon_announcements.png" alt=""></td>
      <td><a href="">John Doe: Announcement tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr class="unread">
      <td class="comment"><img src="pix/icon_discussions.png" alt=""></td>
      <td><a href="">John Doe: Discussion tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr class="unread">
      <td class="resource"><img src="pix/icon_announcements.png" alt=""></td>
      <td><a href="">John Doe: Resource tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr class="unread">
      <td class="announcement"><img src="pix/icon_coursecontent.png" alt=""></td>
      <td><a href="">John Doe: Announcement tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="comment"><img src="pix/icon_discussions.png" alt=""></td>
      <td><a href="">John Doe: Discussion tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="resource"><img src="pix/icon_announcements.png" alt=""></td>
      <td><a href="">John Doe: Resource tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="announcement"><img src="pix/icon_coursecontent.png" alt=""></td>
      <td><a href="">John Doe: Announcement tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="comment"><img src="pix/icon_discussions.png" alt=""></td>
      <td><a href="">John Doe: Discussion tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="resource"><img src="pix/icon_announcements.png" alt=""></td>
      <td><a href="">John Doe: Resource tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="announcement"><img src="pix/icon_coursecontent.png" alt=""></td>
      <td><a href="">John Doe: Announcement tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>
    <tr>
      <td class="comment"><img src="pix/icon_discussions.png" alt=""></td>
      <td><a href="">John Doe: Discussion tomorrow’s lecture notes have been uploaded.</a></td>                   
      <td class="course"><a href="">Photography</a></td>                                     
      <td class="time">Today 10:00 am</td>                                     
      <td class="done"><input type="checkbox"></td>                                                       
    </tr>                                                
  </tbody>
</table>

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