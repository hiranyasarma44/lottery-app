<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'games';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'descriptions', 'banner_image', 'ticket_image', 'price', 'serial_no_range', 'opens_from', 'held_on', 'result_date', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title'     => 'required|alpha_numeric_space|max_length[255]',
        'price'     => 'required|numeric|max_length[10]',
        'descriptions' => 'required|max_length[2000]',
        // 'banner_image' => 'required|max_size[banner_image,2048]|mime_in[banner_image,image/png,image/jpeg]',
        'ticket_image' => 'required',
        'opens_from' => 'required',
        'held_on' => 'required',
        'result_date' => 'required'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
