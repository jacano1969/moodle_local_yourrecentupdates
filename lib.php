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
 * lib functions for your recent updates plugin
 *
 */

function get_recent_updates() {
    return 'no recent updates';    
}


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
    $course_select .= html_writer::start_tag('h3',array('for'=>'course'));
    $course_select .= get_string('updatetype', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('h3');
    
    $course_select .= html_writer::start_tag('ul');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= get_string('all', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_announcements.png'));
    $course_select .= get_string('announcements', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_coursecontent.png'));
    $course_select .= get_string('coursecontent', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('li');    
    
    $course_select .= html_writer::start_tag('li');
    $course_select .= html_writer::start_tag('a', array('href'=>'#'));
    $course_select .= html_writer::empty_tag('img', array('src'=>'pix/icon_discussions.png'));
    $course_select .= get_string('discussions', 'local_yourrecentupdates');
    $course_select .= html_writer::end_tag('li');
    
    $course_select .= html_writer::end_tag('ul');
    $course_select .= html_writer::end_tag('div');
  
    $course_select .= html_writer::start_tag('div', array('class'=>'clearfix'));
    $course_select .= html_writer::end_tag('div');
    
    $course_select .= html_writer::end_tag('div');
    $course_select .= html_writer::end_tag('form');

    return $course_select;
}
  
/*<div class="filters">

  
  <div class="row">  
    <h3>Show updates from&hellip;</h3>
    <p>
      <select name="">
        <option value="">Choose a course&hellip;</option>
      </select>
      <input type="submit" name="" value="Filter" class="submit">
    </p>
  </div>
  
  <div class="row">
    <h3>Show by update type </h3>
    <ul>
      <li><a href="">All</a></li>
      <li><a href=""><img src="pix/icon_announcements.png" alt=""> Announcements</a></li>
      <li><a href=""><img src="pix/icon_coursecontent.png" alt=""> Course content</a></li>
      <li class="last"><a href=""><img src="pix/icon_discussions.png" alt=""> Discussions</a></li>
    </ul>
  </div>
  
  <div class="clearfix"></div>
    
</div><!-- /.filters -->

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