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
 * byauth enrol plugin installation script
 *
 * @package    enrol
 * @subpackage byauth
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

function xmldb_enrol_byauth_install() {
    global $CFG, $DB;

    // migrate welcome message
    if (isset($CFG->sendcoursewelcomemessage)) {
        set_config('sendcoursewelcomemessage', $CFG->sendcoursewelcomemessage, 'enrol_byauth'); // new course default
        $DB->set_field('enrol', 'customint4', $CFG->sendcoursewelcomemessage, array('enrol'=>'byauth')); // each instance has different setting now
        unset_config('sendcoursewelcomemessage');
    }

    // migrate long-time-no-see feature settings
    if (isset($CFG->longtimenosee)) {
        $nosee = $CFG->longtimenosee * 3600 * 24;
        set_config('longtimenosee', $nosee, 'enrol_byauth');
        $DB->set_field('enrol', 'customint2', $nosee, array('enrol'=>'byauth'));
        unset_config('longtimenosee');
    }
}
