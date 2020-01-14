<?php
namespace Osln\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class Tag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tag";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;

    public function findTop()
    {
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->limit(5)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
