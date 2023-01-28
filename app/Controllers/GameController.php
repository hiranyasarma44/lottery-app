<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\TicketModel;
use App\Controllers\BaseController;
use App\Models\ResultModel;

class GameController extends BaseController
{
    protected $gameModel, $ticketModel;
    public function __construct()
    {
        $this->gameModel = new GameModel();
        $this->ticketModel = new TicketModel();
        array_push($this->helpers, 'form', 'file');
    }

    public function index()
    {
        // list games
        $data['gameList'] = $this->gameModel->select('id, title, descriptions, price, held_on, result_date')->orderBy('created_at', 'desc')->findAll();
        echo view('admin/game/index', $data);
    }

    public function getGameInfo($gameId)
    {
        if ($this->request->isAJAX()) {
            $gameInfo = $this->gameModel->find($gameId);
            if (!empty($gameInfo)) {
                $gameInfo['banner_image'] = '/uploads/banners' . $gameInfo['banner_image'];
                $gameInfo['ticket_image'] = '/uploads/tickets' . $gameInfo['ticket_image'];
                $serial_no_range = json_decode($gameInfo['serial_no_range']);
                $gameInfo['start'] = $serial_no_range->start;
                $gameInfo['end'] = $serial_no_range->end;
                $gameInfo['opens_from'] = date('d-m-Y', strtotime($gameInfo['opens_from']));
                $gameInfo['held_on'] = date('d-m-Y', strtotime($gameInfo['held_on']));
                $gameInfo['result_date'] = date('d-m-Y g:i a', strtotime($gameInfo['result_date']));
                unset($gameInfo['created_at']);
                unset($gameInfo['updated_at']);
                echo json_encode([
                    'status' => true,
                    'gameInfo' => $gameInfo
                ]);
                exit();
            }else{
                echo json_encode([
                    'status' => false
                ]);
            exit();
            }
        }else{
            echo view('errors/html/error_404');
            exit();
        }
    }

    public function create()
    { 
        // create the game and return success response
        $formInputs = $this->request->getVar();
        if($formInputs['createGameInfo'] !== 'createGame'){
            session()->setFlashdata('createErrors', 'Invalid attempt');
            return redirect()->back()->withInput();
        }

        // upload banner and ticket image and get respective file names
        $uploaded_banner_image = file_upload($this->request->getFile('banner_image'), 'public/uploads/banners/');
        $formInputs['banner_image'] = $uploaded_banner_image['file_path'];
        $uploaded_ticket_image = file_upload($this->request->getFile('ticket_image'), 'public/uploads/tickets/');
        $formInputs['ticket_image'] = $uploaded_ticket_image['file_path'];
        $rangeStart = $formInputs['start'];
        $rangeEnd = $formInputs['end'];
        unset($formInputs['start']);
        unset($formInputs['end']);
        $formInputs['serial_no_range'] = json_encode([
            'start' => $rangeStart,
            'end' => $rangeEnd
        ]);

        // format dates for opens_from, held_on, result_date
        $formInputs['opens_from'] = date('Y-m-d H:i:s', strtotime($formInputs['opens_from']));
        $formInputs['held_on'] = date('Y-m-d H:i:s', strtotime($formInputs['held_on']));
        $formInputs['result_date'] = date('Y-m-d H:i:s', strtotime($formInputs['result_date']));

        // validate form
        $rules = [];
        if (!$this->validate($rules) && $this->gameModel->save($formInputs)) {
            $this->generateTickets($this->gameModel->getInsertID(),$rangeStart,$rangeEnd);
            session()->setFlashdata('successMsg', 'Game created successfully.');
            return redirect()->to(site_url('/game/list'));
        } else {
            session()->setFlashdata('createErrors', $this->gameModel->errors());
            return redirect()->back()->withInput();
        }
    }

    public function update()
    {
        $formInputs = $this->request->getVar();
        if($formInputs['updateGameInfo'] !== 'updateGame'){
            session()->setFlashdata('error', 'Invalid attempt');
            return redirect()->back()->withInput();
        }
        // upload banner and ticket image and get respective file names
        $bannerImageToUpdate = $this->request->getFile('banner_image');
        if($bannerImageToUpdate->isFIle()){
            $uploaded_banner_image = file_upload($bannerImageToUpdate, 'public/uploads/banners/');
            $formInputs['banner_image'] = $uploaded_banner_image['file_path'];
        }
        $ticketImageToUpdate = $this->request->getFile('ticket_image');

        if($ticketImageToUpdate->isFile()){
            $uploaded_ticket_image = file_upload($ticketImageToUpdate, 'public/uploads/tickets/');
            $formInputs['ticket_image'] = $uploaded_ticket_image['file_path'];
        }
        $rangeStart = $formInputs['start'];
        $rangeEnd = $formInputs['end'];
        $formInputs['serial_no_range'] = json_encode([
            'start' => $rangeStart,
            'end' => $rangeEnd
        ]);
        unset($formInputs['start']);
        unset($formInputs['end']);

        // format dates for opens_from, held_on, result_date
        $formInputs['opens_from'] = date('Y-m-d H:i:s', strtotime($formInputs['opens_from']));
        $formInputs['held_on'] = date('Y-m-d H:i:s', strtotime($formInputs['held_on']));
        $formInputs['result_date'] = date('Y-m-d H:i:s', strtotime($formInputs['result_date']));

        $previousGameInfo = $this->gameModel->select('serial_no_range')->find($formInputs['id']);
        $previousTicketRange = json_decode($previousGameInfo['serial_no_range']);
        if ($this->gameModel->save($formInputs)) {
            if($previousTicketRange->start != $rangeStart || $previousTicketRange->end != $rangeEnd){
                $this->removeTicketByGame($formInputs['id']);
                $this->generateTickets($formInputs['id'],$rangeStart,$rangeEnd);
            }
            session()->setFlashdata('successMsg', 'Game updated successfully.');
            return redirect()->to(site_url('/game/list'));
        } else {
            session()->setFlashdata('updateErrors', $this->gameModel->errors());
            return redirect()->back()->withInput();
        }
    }

    public function delete($gameId){

        // check if any tickets bought
        $tickets = $this->ticketModel->where('game_id',$gameId)->where('member_id !=', null)->find();
        if(!empty($tickets)){
            session()->setFlashdata('deleteFail', 'Unable to delete game. Some tickets already sold.');
            return redirect()->back()->withInput();
        }else{
            // delete tickets
            $this->removeTicketByGame($gameId);
            // delete game
            $this->gameModel->delete(['id' => $gameId]);
            session()->setFlashdata('successMsg', 'Game deleted successfully.');
            return redirect()->to(site_url('/game/list'));
        }

    }

    public function getResults($gameId){
        if($this->request->isAJAX()){
            $resultModel = new ResultModel();
            $results = $resultModel->join('tickets','tickets.id = results.ticket_id')
            ->join('members','members.id = results.member_id')->where('game_id', $gameId)->get();
dump($results);
            echo json_encode([
                'resultTable' => view('admin/components/result-table')
            ]);
        }else{
            $resultModel = new ResultModel();
            $results = $resultModel->join('tickets','tickets.id = results.ticket_id')
            ->join('members','members.id = results.member_id')->where('game_id', $gameId)->get();
dump($results);
            echo view('admin/game/results');
            exit();
        }
    }

    private function generateTickets($gameId, $start, $end){
        $tickets = [];
        for($i = $start; $i<= $end; $i++){
            array_push($tickets,[
                'game_id' => $gameId,
                'sl_no' => $i
            ]);
        }
        $this->ticketModel->insertBatch($tickets);
    }

    private function removeTicketByGame($gameId){
        return $this->ticketModel->where('game_id', $gameId)->delete();
    }
}
