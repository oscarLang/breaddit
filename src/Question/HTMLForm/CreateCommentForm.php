<?php

namespace Osln\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Osln\Question\Question;
use Osln\Tag\Tag;
use Osln\Tag\QuestionToTag;
use Osln\Question\Comment;

/**
 * Form to create an item.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $parent, $questionId)
    {
        parent::__construct($di);
        $this->parent = $parent;
        $this->questionId = $questionId;
        // var_dump($allTagsArr);
        $this->form->create(
            [
                "id" => __CLASS__ . $parent,
            ],
            [
                "comment" => [
                    "id" => "comment" . $parent,
                    "type"        => "textarea",
                    "placeholder" => "What are your thoughts?",
                ],

                "submit" => [
                    "id" => "submit" . $parent,
                    "type" => "submit",
                    "value" => "Comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $session = $this->di->get("session");
        if (!$session->has("user")) {
            return false;
        }
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->content = $this->form->value("comment");
        $comment->user_id = $session->get("user")["id"];
        $comment->parent_comment_id = $this->parent;
        $comment->question_id = $this->questionId;
        $comment->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("question")->send();
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
