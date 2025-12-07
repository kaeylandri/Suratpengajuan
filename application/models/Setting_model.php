<?php
class Setting_model extends CI_Model
{
    public function getPin()
    {
        $query = $this->db->get_where('settings', ['id' => 1])->row();
        return $query ? $query->pin : null;
    }

    public function updatePin($newPin)
    {
        return $this->db->where('id', 1)->update('settings', [
            'pin' => $newPin
        ]);
    }
}
