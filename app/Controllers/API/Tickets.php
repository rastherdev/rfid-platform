<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TicketModel;

class Tickets extends ResourceController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    public function createTicket()
    {
        try {
            $ticket = $this->request->getJSON();
            $ticketType = substr($ticket->tag, 0, 1);
            $tag = substr($ticket->tag, 2);

            if ($this->ticketModel->checkIfExistTag($tag)) {
                $user = $this->ticketModel->getUserByTag($tag);
                $this->ticketModel->createNewTicket($user, $ticketType);
                return $this->respondCreated('ok con tag');
            } else {
                return $this->respondCreated('ok sin tag');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error.');
        }
    }
}
