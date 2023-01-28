<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\TicketModel;

class Home extends BaseController
{
    private $gameModel, $ticketModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
        $this->ticketModel = new TicketModel();
    }

    public function index()
    {
        $gameList =  $this->gameModel->select('id, title, banner_image, result_date')->orderBy('created_at', 'desc')->limit(3)->find();
        $data = [
            'gameList' => $gameList
        ];
        return view('pages/home', $data);
    }

    public function details($gameId){
        $gameInfo = $this->gameModel->select('id, title, descriptions, ticket_image, result_date, price, serial_no_range')->find($gameId);
        $tickets = $this->ticketModel
            ->select('id, sl_no')
            ->where('game_id',$gameId)
            ->where('member_id', null)
            ->find();
        $data = [
            'gameInfo' => $gameInfo,
            'tickets'  => $tickets
        ];
        return view('pages/details', $data);
    }

    public function viewMore(){
        $data['gameList'] = $this->gameModel->select('id, title, descriptions, price, held_on, result_date')->orderBy('created_at', 'desc')->findAll();
        echo view('pages/view-more', $data);
    }
}
