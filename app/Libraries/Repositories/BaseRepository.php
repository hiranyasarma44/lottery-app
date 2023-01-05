<?php
namespace App\Libraries\Repositories;
use CodeIgniter\Model;

abstract class BaseRepository extends Model implements IRepository
{
    /**
     * This must be valid table name in the Database.
     *
     * @var string $table Name of the table.
     */
    protected $table;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Pseudo method overloading.
     * It's called when method is not declared in the abstract class.
     *
     * @param string $name      Name of the method
     * @param mixed  $arguments Arguments of the method
     */
    public function __call($name, $arguments)
    {
        switch ($name)
        {
            case 'save':
                if ($arguments[0]->id > 0)
                {
                    $this->update($arguments[0]);
                }
                else
                {
                    $this->insert($arguments[0]);
                }
            break;
        }
    }

    /**
     * Get row with id.
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    /**
     * Select columns.
     *
     * @param  array $columns
     * @return mixed
     */
    public function select($columns = ['*'])
    {
        $this->db->select($columns);
        return $this->db->get($this->table)->result();
    }

    /**
     * Insert data.
     *
     * @param  object $item
     * @return void
     */
    private function insert($item)
    {
        unset($item->id);
        $this->db->insert($this->table, $item);
    }

    /**
     * Update data.
     *
     * @param  object $item
     * @return void
     */
    private function update($item)
    {
        $this->db->where('id =', $item->id);
        unset($item->id);
        $this->db->update($this->table, $item);
    }

    /**
     * Delete data.
     *
     * @param  integer $id
     * @return void
     */
    public function delete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
    }

}