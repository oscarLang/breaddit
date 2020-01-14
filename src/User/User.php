<?php
namespace Osln\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $email;
    public $password;
    public $gravatar;

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($acronym, $password)
    {
        $this->find("acronym", $acronym);
        return password_verify($password, $this->password);
    }

    public function generateGravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        $this->gravatar = $url;
    }

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
