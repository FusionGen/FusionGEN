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

        if ($sessions) {
            foreach ($sessions as $key => $value) {
                if ($value['data']) {
                    $data = unserialize($value['data']);
                    $sessions[$key]['id'] = $this->getUserId($data);
                    $sessions[$key]['nickname'] = $this->getNickname($data);
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

        $this->administrator->view($content);
    }

    private function getUserId($data)
    {
        if (array_key_exists("id", $data)) {
            return $data['id'];
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
}
