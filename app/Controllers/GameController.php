<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class GameController extends Controller
{
    protected $gameModel;
    public function __construct(){
        $this->gameModel = new GameModel();

    }

    public function index()
    {
        // list games

        echo view('pages/admin/game/index');
    }

    public function create(){
        // create the game and return success response
        $formInputs = $this->request->getVar();
        
        // upload banner and ticket image and get respective file names

        // replace banner and ticket image name

        // check and replace banner and ticket name if already exists

        // format dates for opens_from, held_on, result_date
        $formInputs['opens_from'] = date('Y-m-d H:i:s', strtotime($formInputs['opens_from']));
        $formInputs['held_on'] = date('Y-m-d H:i:s', strtotime($formInputs['held_on']));
        $formInputs['result_date'] = date('Y-m-d H:i:s', strtotime($formInputs['result_date']));

        // save
        $data = [
            'title' => 'abc',
            'descriptions' => 'abcers',
            'banner_image' => 'fda',
            'ticket_image' => 'fdaa',
            'price' => '100',
            'serial_no_range' => json_encode(['start' => 100, 'end' => '999']),
            'opens_from' => date('Y-m-d H:i:s'),
            'held_on' => date('Y-m-d H:i:s'),
            'result_date' => date('Y-m-d H:i:s')
        ];
        
        var_dump($this->gameModel->save($data));

        
    }
}
