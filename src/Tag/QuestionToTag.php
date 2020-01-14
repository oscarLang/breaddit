<?php
namespace Osln\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class QuestionToTag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "QuestionToTag";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag_id;
    public $question_id;

    public function findAllQuestionsByTag($tagId)
    {
        $where = "QuestionToTag.tag_id = ?";
        $group = "Question.id";
        return $this->joinUserQuestionTagBy($where, $tagId, $group);
    }

    public function findAllQuestionsByUsername($username)
    {
        $where = "User.acronym = ?";
        $group = "Question.id";
        return $this->joinUserQuestionTagBy($where, $username, $group);
    }

    private function joinUserQuestionTagBy($where, $value, $group)
    {
        $select = "
            Question.id AS question_id,
            Question.created,
            Question.title,
            group_concat(Tag.id || '-' || Tag.name) AS tags,
            User.acronym,
            QuestionToTag.id AS q_t_id";
        $this->checkDb();
        return $this->db->connect()
                       ->select($select)
                       ->from($this->tableName)
                       ->leftJoin("Question", "Question.id = QuestionToTag.question_id")
                       ->leftJoin("Tag", "Tag.id = QuestionToTag.tag_id")
                       ->leftJoin("User", "Question.user_id = User.id")
                       ->where($where)
                       ->groupBy($group)
                       ->execute([$value])
                       ->fetchAllClass(get_class($this));
    }
}
