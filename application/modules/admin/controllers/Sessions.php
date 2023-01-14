<?php

class Sessions extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('session_model');

        requirePermission("viewSessions");
    }

    public function index()
    {
        $sessions = $this->session_model->get();

        if ($sessions)
		{
            foreach ($sessions as $key => $value) {
				$session = $this->session_model->getSessId($sessions[$key]['id']);
				if (!empty($session['data']))
				{
					$session = $this->parseSession($session['data']);
					$session = unserialize($session);
				}

                if ($this->getUserId($session))
				{
                    $sessions[$key]['uid'] = $this->getUserId($session);
                    $sessions[$key]['nickname'] = $this->getNickname($session);
                }

                $date = new DateTime();
                $date->setTimestamp($value["timestamp"]);

                $sessions[$key]['os'] = $this->getPlatform($value['user_agent']);
                $sessions[$key]['browser'] = $this->getBrowser($value['user_agent']);
                $sessions[$key]['date'] = $date->format("d.m.y H:i:s");
            }
        }

        $data = array(
            'sessions' => $sessions
        );

        $output = $this->template->loadPage("sessions/sessions.tpl", $data);
        $content = $this->administrator->box('Active sessions', $output);

        $this->administrator->view($content, false, "modules/admin/js/session.js");
    }

    private function getUserId($data)
    {
        if (array_key_exists("uid", $data)) {
            return $data['uid'];
        }
		else
		{
			return false;
		}
    }

    private function getNickname($data)
    {
        if (array_key_exists("nickname", $data)) {
            return $data['nickname'];
        }
    }

    private function getBrowser($u_agent)
    {
        if (preg_match('/trident/i', $u_agent) && !preg_match('/opera/i', $u_agent)) {
            return "ie";
        } elseif (preg_match('/opera/i', $u_agent)) {
            return "opera";
        } elseif (preg_match('/firefox/i', $u_agent)) {
            return "firefox";
        } elseif (preg_match('/edg/i', $u_agent)) {
            return "edge";
        } elseif (preg_match('/chrome/i', $u_agent)) {
            return "chrome";
        } elseif (preg_match('/android/i', $u_agent)) {
            return "android";
        } elseif (preg_match('/safari/i', $u_agent)) {
            return "safari";
        } else {
            // Default to most common one to prevent errors
            return "chrome";
        }
    }

    private function getPlatform($u_agent)
    {
        if (preg_match('/android/i', $u_agent)) {
            return "android";
        } elseif (preg_match('/linux/i', $u_agent)) {
            return "linux";
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            return "windows";
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            return "mac";
        } else {
            // Default to most common one to prevent errors
            return "windows";
        }
    }
	
    private function parseSession($sess_data)
    {
        $sess_data = rtrim($sess_data, ";");
        $sess_info = array();
        $parts = explode(";", $sess_data);
        
        foreach ($parts as $part) {
            $part = explode("|", $part);
            $key = preg_replace('/:.*/', '', $part[0]);
            $value = preg_replace('/.*:/', '', $part[1]);
            $value = str_replace('"', '', $value);
            $sess_info[$key] = $value;
        }
        unset($sess_info["__ci_last_regenerate"]);
        unset($sess_info["captcha"]);
        unset($sess_info[""]);
        unset($sess_info["admin_access"]);
        unset($sess_info["language"]);
        unset($sess_info["expansion"]);
        unset($sess_info["password"]);
        unset($sess_info["email"]);
        unset($sess_info["last_ip"]);
        unset($sess_info["register_date"]);
        
        $sess_info = serialize($sess_info);
        return $sess_info;
    }

    public function deleteSessions()
    {
        $ip_address = $this->input->ip_address();

        $this->session_model->deleteSessions($ip_address);

        die('1');
    }
}
