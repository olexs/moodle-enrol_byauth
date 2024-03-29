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
 * Adds new instance of enrol_byauth to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage byauth
 * @copyright  2012 Olexandr Savchuk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/moodlelib.php');

class enrol_byauth_edit_form extends moodleform {

    function definition() {
        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_byauth'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));

        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        $mform->addElement('select', 'status', get_string('status', 'enrol_byauth'), $options);
        $mform->addHelpButton('status', 'status', 'enrol_byauth');
        $mform->setDefault('status', $plugin->get_config('status'));

		
		
		$mform->addElement('header', 'header', get_string('authmethods', 'enrol_byauth'));
		
		$standards = array(
			'tuid' => 'allow'
		);
		$options = array('allow' => get_string('allowenrolment', 'enrol_byauth'),
							'password' => get_string('allowenrolmentwithpassword', 'enrol_byauth'),
							'forbid' => get_string('forbidenrolment', 'enrol_byauth'));
		$auths = get_enabled_auth_plugins();
		foreach ($auths as $authname) {
			if ($authname == 'nologin')
				continue;
		
			$auth = get_auth_plugin($authname);
			
			$mform->addElement('select', 'auth['.$authname.']', $auth->get_title(), $options);
			$mform->setDefault('auth['.$authname.']', isset($standards[$authname]) ? $standards[$authname] : 'password');
			if (get_string_manager()->string_exists('desc_auth_'.$authname, 'enrol_byauth'))
				$mform->addElement('static', '', '', get_string('desc_auth_'.$authname, 'enrol_byauth'));
		}
		
		
		$mform->addElement('header', 'header', get_string('password', 'enrol_byauth'));
		
        $mform->addElement('passwordunmask', 'password', get_string('password', 'enrol_byauth'));
        $mform->addHelpButton('password', 'password', 'enrol_byauth');
        if (empty($instance->id) and $plugin->get_config('requirepassword')) {
            $mform->addRule('password', get_string('required'), 'required', null, 'client');
        }

        $options = array(1 => get_string('yes'),
                         0 => get_string('no'));
        $mform->addElement('select', 'customint1', get_string('groupkey', 'enrol_byauth'), $options);
        $mform->addHelpButton('customint1', 'groupkey', 'enrol_byauth');
        $mform->setDefault('customint1', $plugin->get_config('groupkey'));
		
		
		
		$mform->addElement('header', 'header', get_string('additionaloptions', 'enrol_byauth'));

        if ($instance->id) {
            $roles = $this->extend_assignable_roles($context, $instance->roleid);
        } else {
            $roles = $this->extend_assignable_roles($context, $plugin->get_config('roleid'));
        }
        $mform->addElement('select', 'roleid', get_string('role', 'enrol_byauth'), $roles);
        $mform->setDefault('roleid', $plugin->get_config('roleid'));

        $mform->addElement('duration', 'enrolperiod', get_string('enrolperiod', 'enrol_byauth'), array('optional' => true, 'defaultunit' => 86400));
        $mform->setDefault('enrolperiod', $plugin->get_config('enrolperiod'));
        $mform->addHelpButton('enrolperiod', 'enrolperiod', 'enrol_byauth');

        $mform->addElement('date_selector', 'enrolstartdate', get_string('enrolstartdate', 'enrol_byauth'), array('optional' => true));
        $mform->setDefault('enrolstartdate', 0);
        $mform->addHelpButton('enrolstartdate', 'enrolstartdate', 'enrol_byauth');

        $mform->addElement('date_selector', 'enrolenddate', get_string('enrolenddate', 'enrol_byauth'), array('optional' => true));
        $mform->setDefault('enrolenddate', 0);
        $mform->addHelpButton('enrolenddate', 'enrolenddate', 'enrol_byauth');

        $options = array(0 => get_string('never'),
                 1800 * 3600 * 24 => get_string('numdays', '', 1800),
                 1000 * 3600 * 24 => get_string('numdays', '', 1000),
                 365 * 3600 * 24 => get_string('numdays', '', 365),
                 180 * 3600 * 24 => get_string('numdays', '', 180),
                 150 * 3600 * 24 => get_string('numdays', '', 150),
                 120 * 3600 * 24 => get_string('numdays', '', 120),
                 90 * 3600 * 24 => get_string('numdays', '', 90),
                 60 * 3600 * 24 => get_string('numdays', '', 60),
                 30 * 3600 * 24 => get_string('numdays', '', 30),
                 21 * 3600 * 24 => get_string('numdays', '', 21),
                 14 * 3600 * 24 => get_string('numdays', '', 14),
                 7 * 3600 * 24 => get_string('numdays', '', 7));
        $mform->addElement('select', 'customint2', get_string('longtimenosee', 'enrol_byauth'), $options);
        $mform->setDefault('customint2', $plugin->get_config('longtimenosee'));
        $mform->addHelpButton('customint2', 'longtimenosee', 'enrol_byauth');

        $mform->addElement('text', 'customint3', get_string('maxenrolled', 'enrol_byauth'));
        $mform->setDefault('customint3', $plugin->get_config('maxenrolled'));
        $mform->addHelpButton('customint3', 'maxenrolled', 'enrol_byauth');
        $mform->setType('customint3', PARAM_INT);

        $mform->addElement('advcheckbox', 'customint4', get_string('sendcoursewelcomemessage', 'enrol_byauth'));
        $mform->setDefault('customint4', $plugin->get_config('sendcoursewelcomemessage'));
        $mform->addHelpButton('customint4', 'sendcoursewelcomemessage', 'enrol_byauth');

        $mform->addElement('textarea', 'customtext1', get_string('customwelcomemessage', 'enrol_byauth'), array('cols'=>'60', 'rows'=>'8'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

		// somewhat hacked data preprocessing		
		if ($instance->id) {
			$authdata = json_decode($instance->customtext2, true);
			foreach($authdata as $authname => $authvalue) {
				$fieldname = "auth[$authname]";
				$instance->$fieldname = $authvalue;
			}
		}
		
        $this->set_data($instance);
    }
	
	function validation($data, $files) {
        global $DB, $CFG;
        $errors = parent::validation($data, $files);

        list($instance, $plugin, $context) = $this->_customdata;
        $checkpassword = false;
		$require = false;

        if ($instance->id) {
            if ($data['status'] == ENROL_INSTANCE_ENABLED) {
                if ($instance->password !== $data['password']) {
                    $checkpassword = true;
                }
            }
        } else {
            if ($data['status'] == ENROL_INSTANCE_ENABLED) {
                $checkpassword = true;
            }
        }
		
		$auths = get_enabled_auth_plugins();
		foreach ($auths as $authname) {
			if (isset($data['auth'][$authname]) && $data['auth'][$authname] == 'password') {
				$checkpassword = true;
				$require = true;
			}	
		}

        if ($checkpassword) {
            $require = $require || $plugin->get_config('requirepassword');
            $policy  = $plugin->get_config('usepasswordpolicy');
            if ($require and trim($data['password']) === '') {
                $errors['password'] = get_string('required');
            } else if ($policy) {
                $errmsg = '';//prevent eclipse warning
                if (!check_password_policy($data['password'], $errmsg)) {
                    $errors['password'] = $errmsg;
                }
            }
        }

        if ($data['status'] == ENROL_INSTANCE_ENABLED) {
            if (!empty($data['enrolenddate']) and $data['enrolenddate'] < $data['enrolstartdate']) {
                $errors['enrolenddate'] = get_string('enrolenddaterror', 'enrol_byauth');
            }
        }

        return $errors;
    }

    /**
    * Gets a list of roles that this user can assign for the course as the default for byauth-enrolment
    *
    * @param context $context the context.
    * @param integer $defaultrole the id of the role that is set as the default for byauth-enrolement
    * @return array index is the role id, value is the role name
    */
    function extend_assignable_roles($context, $defaultrole) {
        global $DB;
        $roles = get_assignable_roles($context);
        $sql = "SELECT r.id, r.name
                  FROM {role} r
                 WHERE r.id = $defaultrole";
        $results = $DB->get_record_sql($sql);
        if (isset($results->name)) {
            $roles[$results->id] = $results->name;
        }
        return $roles;
    }
}