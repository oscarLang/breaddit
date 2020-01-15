<?php

namespace Osln\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Textfilter\Textfilter;
use Osln\Tag\Tag;
use Osln\Tag\QuestionToTag;
use Osln\User\User;
/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $content;
    public $user_id;

    public function getLatestArray($user, $tag, $questionTag)
    {
        $questions = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->limit(3)
                        ->execute()
                        ->orderBy("created DESC")
                        ->fetchAllClass(get_class($this));
        $questionPrint = [];
        foreach ($questions as $question) {
            $new = $this->createArray($question, $user, $tag, $questionTag);
            $questionPrint[] = $new;
        }
        return $questionPrint;
    }

    public function getAllPrintableArray($user, $tag, $questionTag)
    {
        $questions = $this->findAll();
        $questionPrint = [];
        foreach ($questions as $question) {
            $new = $this->createArray($question, $user, $tag, $questionTag);
            $questionPrint[] = $new;
        }
        return $questionPrint;
    }

    public function getPrintableArray($questionId, $user, $tag, $questionTag)
    {
        $question = $this->findWhere("id = ?", $questionId);
        return $this->createArray($question, $user, $tag, $questionTag);
    }

    private function createArray($question, $user, $tag, $questionTag)
    {
        $new = [];
        $new["id"] = $question->id;
        $new["created"] = $question->created;
        $new["title"] = $question->title;
        $new["content"] = $question->content;
        $allTagsById = $questionTag->findAllWhere("question_id = ?", $question->id);
        // var_dump($allTagsById);
        $allTags = [];
        foreach ($allTagsById as $tagsById) {
            $allTagsFromDb = $tag->findAllWhere("id = ?", $tagsById->tag_id);
            foreach ($allTagsFromDb as $tagDb) {
                $allTags[$tagDb->id] = $tagDb->name;
            }
        }
        $new["tags"] = $allTags;
        $new["author"] = $user->findWhere("id = ?", $question->user_id)->acronym;
        return $new;
    }
}
