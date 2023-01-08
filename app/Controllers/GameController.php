<?php

namespace App\Controllers;

use App\Models\GameModel;
use CodeIgniter\Controller;

class GameController extends Controller
{
    protected $gameModel;
    public function __construct()
    {
        $this->gameModel = new GameModel();
        helper(['file', 'dev']);
    }

    public function index()
    {
        // list games
        $data['gameList'] = $this->gameModel->select('id, title, descriptions, price, held_on')->findAll();
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
                $gameInfo['result_date'] = date('d-m-Y', strtotime($gameInfo['result_date']));
                unset($gameInfo['created_at']);
                unset($gameInfo['updated_at']);
                echo json_encode([
                    'status' => true,
                    'gameInfo' => $gameInfo
                ]);
                exit();
            }

            echo json_encode([
                'status' => false
            ]);
        }

        exit();
    }

    public function create()
    { 
        // create the game and return success response
        $formInputs = $this->request->getVar();

        // upload banner and ticket image and get respective file names
        $uploaded_banner_image = file_upload($this->request->getFile('banner_image'), 'public/uploads/banners/');
        $formInputs['banner_image'] = $uploaded_banner_image['file_path'];
        $uploaded_ticket_image = file_upload($this->request->getFile('ticket_image'), 'public/uploads/tickets/');
        $formInputs['ticket_image'] = $uploaded_ticket_image['file_path'];
        $formInputs['serial_no_range'] = json_encode([
            'start' => $formInputs['start'],
            'end' => $formInputs['end']
        ]);

        // format dates for opens_from, held_on, result_date
        $formInputs['opens_from'] = date('Y-m-d H:i:s', strtotime($formInputs['opens_from']));
        $formInputs['held_on'] = date('Y-m-d H:i:s', strtotime($formInputs['held_on']));
        $formInputs['result_date'] = date('Y-m-d H:i:s', strtotime($formInputs['result_date']));

        unset($formInputs['start']);
        unset($formInputs['end']);

        if ($this->gameModel->save($formInputs)) {
            return redirect()->to(site_url('/game/list'));
        } else {
            session()->setFlashdata('error', $this->gameModel->errors());
            return redirect()->back()->withInput();
        }
    }


    public function update()
    {
        $formInputs = $this->request->getVar();
        dump($formInputs);

        // upload banner and ticket image and get respective file names
        $uploaded_banner_image = file_upload($this->request->getFile('banner_image'), 'public/uploads/banners/');
        $formInputs['banner_image'] = $uploaded_banner_image['file_path'];
        $uploaded_ticket_image = file_upload($this->request->getFile('ticket_image'), 'public/uploads/tickets/');
        $formInputs['ticket_image'] = $uploaded_ticket_image['file_path'];
        $formInputs['serial_no_range'] = json_encode([
            'start' => $formInputs['start'],
            'end' => $formInputs['end']
        ]);

        // format dates for opens_from, held_on, result_date
        $formInputs['opens_from'] = date('Y-m-d H:i:s', strtotime($formInputs['opens_from']));
        $formInputs['held_on'] = date('Y-m-d H:i:s', strtotime($formInputs['held_on']));
        $formInputs['result_date'] = date('Y-m-d H:i:s', strtotime($formInputs['result_date']));

        unset($formInputs['start']);
        unset($formInputs['end']);
        if ($this->gameModel->save($formInputs)) {
            return redirect()->to(site_url('/game/list'));
        } else {
            session()->setFlashdata('error', $this->gameModel->errors());
            return redirect()->back()->withInput();
        }
    }
}
