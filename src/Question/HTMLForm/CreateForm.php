<?php

namespace Osln\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Osln\Question\Question;
use Osln\Tag\Tag;
use Osln\Tag\QuestionToTag;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $allTags = $tag->findAll();
        $allTagsArr = [];
        foreach ($allTags as $tag) {
            $allTagsArr[$tag->name] = $tag->name;
        }
        // var_dump($allTagsArr);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the question",
            ],
            [
                "Title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "Content" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "Tags" => [
                    "type" => "text",
                ],

                "selecttags" => [
                    "type" => "select-multiple",
                    "label" => "Or select one or more tags this list",
                    "options" => $allTagsArr,
                    "checked" => [],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create question thread",
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


        $allTagNames = [];
        $allSelectedTags = $this->form->value("selecttags");
        if ($this->form->value("Tags") != null) {
            $allTagNames = array_merge([$this->form->value("Tags")], $allSelectedTags);
        } else {
            $allTagNames = $allSelectedTags;
        }


        $user = $session->get("user");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $this->form->value("Title");
        $question->content = $this->form->value("Content");
        $question->user_id = $user["id"];
        $question->save();

        foreach ($allTagNames as $tagName) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            if ($tag->find("name", $tagName)->id == null) {
                // $this->form->addOutput("yesss");
                $tag->name = $tagName;
                $tag->save();
            }
            $questionTag = new QuestionToTag();
            $questionTag->setDb($this->di->get("dbqb"));
            $questionTag->tag_id = $tag->id;
            $questionTag->question_id = $question->id;
            $questionTag->save();
        }
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question")->send();
    }



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
