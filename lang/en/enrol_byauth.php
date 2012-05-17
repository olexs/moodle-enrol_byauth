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
 * Strings for component 'enrol_byauth', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package    enrol
 * @subpackage byauth
 * @copyright  2012 Olexandr Savchuk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
$string['additionaloptions'] = 'Additional options';
$string['authmethods'] = 'Authentication methods';
$string['authmethods_help'] = 'Choose which authentication methods will allow users to enrol in the course.

You can allow all users with a given authentication method to enrol in the course, limit a certain authentication method with an enrolment key, or forbid enrolment for a certain authentication method altogether.';
$string['allowenrolment'] = 'Allow, no key';
$string['allowenrolmentwithpassword'] = 'Allow, with key';
$string['forbidenrolment'] = 'Forbid';
$string['desc_auth_manual'] = 'User accounts created manually by Moodle administrators';
$string['desc_auth_email'] = 'Self-registered user accounts';
$string['desc_auth_tuid'] = 'User accounts using the TU-ID system';

$string['customwelcomemessage'] = 'Custom welcome message';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during self enrolment';
$string['editenrolment'] = 'Edit enrolment';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can enrol themselves until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolme'] = 'Enrol me';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid (in seconds). If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user enrols themselves. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can enrol themselves from this date onward only.';
$string['groupkey'] = 'Use group enrolment keys';
$string['groupkey_desc'] = 'Use group enrolment keys by default.';
$string['groupkey_help'] = 'In addition to restricting access to the course to only those who know the key, use of a group enrolment key means users are automatically added to the group when they enrol in the course.

To use a group enrolment key, an enrolment key must be specified in the course settings as well as the group enrolment key in the group settings.';
$string['longtimenosee'] = 'Unenrol inactive after';
$string['longtimenosee_help'] = 'If users haven\'t accessed a course for a long time, then they are automatically unenrolled. This parameter specifies that time limit.';
$string['maxenrolled'] = 'Max enrolled users';
$string['maxenrolled_help'] = 'Specifies the maximum number of users that can self enrol. 0 means no limit.';
$string['maxenrolledreached'] = 'Maximum number of users allowed to self-enrol was already reached.';
$string['nopassword'] = 'No enrolment key required.';
$string['noenroll'] = 'You cannot enrol in this course.';
$string['password'] = 'Enrolment key';
$string['password_help'] = 'A key needs to be provided by users, whose authentication method is set above to require an enrolment key. Users with authentication methods set above to allow self-enrolment without a key will not need one.

You do not need to set a key if you chose no authentication methods above to require it.';
$string['passwordinvalid'] = 'Incorrect enrolment key, please try again';
$string['passwordinvalidhint'] = 'That enrolment key was incorrect, please try again<br />
(Here\'s a hint - it starts with \'{$a}\')';
$string['pluginname'] = 'Authentication-based self enrolment';
$string['pluginname_desc'] = 'The authentication-based self enrolment plugin allows users to choose which courses they want to participate in. The courses may be protected by an enrolment key or locked for certain users, based on their authentication method. Internally the enrolment is done via the manual enrolment plugin which has to be enabled in the same course.';
$string['requirepassword'] = 'Require enrolment key';
$string['requirepassword_desc'] = 'Require enrolment key in new courses and prevent removing of enrolment key from existing courses.';
$string['role'] = 'Default assigned role';
$string['byauth:config'] = 'Configure auth-based self enrol instances';
$string['byauth:manage'] = 'Manage enrolled users';
$string['byauth:unenrol'] = 'Unenrol users from course';
$string['byauth:unenrolbyauth'] = 'Unenrol self from the course';
$string['sendcoursewelcomemessage'] = 'Send course welcome message';
$string['sendcoursewelcomemessage_help'] = 'If enabled, users receive a welcome message via email when they enrol in a course.';
$string['showhint'] = 'Show hint';
$string['showhint_desc'] = 'Show first letter of the guest access key.';
$string['status'] = 'Allow self enrolments';
$string['status_desc'] = 'Allow users to self enrol into course according to the following settings.';
$string['status_help'] = 'This setting determines whether a user can enrol (and also unenrol if they have the appropriate permission) themselves from the course.';
$string['unenrol'] = 'Unenrol user';
$string['unenrolbyauthconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';
$string['unenroluser'] = 'Do you really want to unenrol "{$a->user}" from course "{$a->course}"?';
$string['usepasswordpolicy'] = 'Use password policy';
$string['usepasswordpolicy_desc'] = 'Use standard password policy for enrolment keys.';
$string['welcometocourse'] = 'Welcome to {$a}';
$string['welcometocoursetext'] = 'Welcome to {$a->coursename}!

If you have not done so already, you should edit your profile page so that we can learn more about you:

  {$a->profileurl}';
