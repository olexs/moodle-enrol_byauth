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
 * byauth enrol plugin implementation.
 *
 * @package    enrol
 * @subpackage byauth
 * @copyright  2012 Olexandr Savchuk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class enrol_byauth_enrol_form extends moodleform {
    protected $instance;
    protected $toomany = false;

    /**
     * Overriding this function to get unique form id for multiple byauth enrolments
     *
     * @return string form identifier
     */
    protected function get_form_identifier() {
        $formid = $this->_customdata->id.'_'.get_class($this);
        return $formid;
    }

    public function definition() {
        global $DB, $USER;

        $mform = $this->_form;
        $instance = $this->_customdata;
        $this->instance = $instance;
        $plugin = enrol_get_plugin('byauth');

        $heading = $plugin->get_instance_name($instance);
        $mform->addElement('header', 'byauthheader', $heading);

        if ($instance->customint3 > 0) {
            // max enrol limit specified
            $count = $DB->count_records('user_enrolments', array('enrolid'=>$instance->id));
            if ($count >= $instance->customint3) {
                // bad luck, no more byauth enrolments here
                $this->toomany = true;
                $mform->addElement('static', 'notice', '', get_string('maxenrolledreached', 'enrol_byauth'));
                return;
            }
        }
		
		$enrollability = $plugin->get_user_enrollability($instance, $USER);
		
        if ($enrollability == 'password') {
            //change the id of byauth enrolment key input as there can be multiple byauth enrolment methods
			$mform->addElement('passwordunmask', 'enrolpassword', get_string('password', 'enrol_byauth'),
                    array('id' => $instance->id."_enrolpassword"));
        } elseif ($enrollability == 'allow') {
			$mform->addElement('hidden', 'enrolpassword', '');
            $mform->addElement('static', 'nokey', '', get_string('nopassword', 'enrol_byauth'));
        } else {
			$mform->addElement('static', 'noenroll', '', get_string('noenroll', 'enrol_byauth'));
		}

		if ($enrollability == 'password' || $enrollability == 'allow')
			$this->add_action_buttons(false, get_string('enrolme', 'enrol_byauth'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $instance->courseid);

        $mform->addElement('hidden', 'instance');
        $mform->setType('instance', PARAM_INT);
        $mform->setDefault('instance', $instance->id);
    }

    public function validation($data, $files) {
        global $DB, $CFG, $USER;

        $errors = parent::validation($data, $files);
        $instance = $this->instance;
		$plugin = enrol_get_plugin('byauth');
		$enrollability = $plugin->get_user_enrollability($instance, $USER);

		if ($this->toomany || $enrollability == 'forbid') {
            $errors['notice'] = get_string('error');
            return $errors;
        }
		
        if ($enrollability == 'password') {
            if ($data['enrolpassword'] !== $instance->password) {
                if ($instance->customint1) {
                    $groups = $DB->get_records('groups', array('courseid'=>$instance->courseid), 'id ASC', 'id, enrolmentkey');
                    $found = false;
                    foreach ($groups as $group) {
                        if (empty($group->enrolmentkey)) {
                            continue;
                        }
                        if ($group->enrolmentkey === $data['enrolpassword']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        // we can not hint because there are probably multiple passwords
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_byauth');
                    }

                } else {
                    $plugin = enrol_get_plugin('byauth');
                    if ($plugin->get_config('showhint')) {
                        $textlib = textlib_get_instance();
                        $hint = $textlib->substr($instance->password, 0, 1);
                        $errors['enrolpassword'] = get_string('passwordinvalidhint', 'enrol_byauth', $hint);
                    } else {
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_byauth');
                    }
                }
            }
        }

        return $errors;
    }
}