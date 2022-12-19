<?php

class Settings_model extends CI_Model
{
    public function saveSettings($values)
    {
        $this->db->update('account_data', $values, array('id' => $this->user->getId()));
    }

    public function setAvatar($user, $avatar)
    {
        $this->db->set('avatar', $avatar);
        $this->db->where('id', $user);
        $this->db->update('account_data');
    }

    public function removeAvatar($user)
    {
        $this->db->set('avatar', 'default.gif');
        $this->db->where('id', $user);
        $this->db->update('account_data');
    }
}
