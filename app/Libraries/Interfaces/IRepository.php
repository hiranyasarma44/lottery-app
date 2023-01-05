<?php
namespace App\Libraries\Repositories;

interface IRepository
{
  public function getById($id);
  public function select($columns);
  public function create($entity);
  public function update($id, $entity);
  public function delete($id);
}
