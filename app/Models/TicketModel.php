<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    public function checkIfExistTag($tag){
        $builder = $this->db->table('users');
        $builder->select('idUser');
        $builder->where('tag', $tag);
        $result = $builder->get();
        if (count($result->getResultArray()) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByTag($tag){
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('tag', $tag);
        $result = $builder->get();
        return $result->getRow();
    }

    public function createNewTicket($user, $ticketType){
        $data = [
            'type' => $ticketType,
            'idUser' => $user->idUser
        ];
        $builder = $this->db->table('tickets');
        $builder->insert($data);
    }
}