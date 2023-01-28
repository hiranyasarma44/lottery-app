<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MemberModel;

class MemberController extends BaseController
{
    protected $memberModel;
    public function __construct(){
        $this->memberModel = new MemberModel();
    }
    public function index()
    {
        $memberList = $this->memberModel->select('id, name, mobile_number, email_id')->findAll();
        $data = [
            'memberList' => $memberList
        ];
        echo view('admin/member/index', $data);
    }
}
