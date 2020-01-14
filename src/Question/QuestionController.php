<?php

namespace Osln\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Osln\Question\HTMLForm\CreateForm;
use Osln\Question\HTMLForm\CreateCommentForm;
use Osln\Question\HTMLForm\EditForm;
use Osln\Question\HTMLForm\DeleteForm;
use Osln\Question\HTMLForm\UpdateForm;
use Osln\Tag\Tag;
use Osln\Tag\QuestionToTag;
use Osln\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->question = new Question();
        $this->question->setDb($this->di->get("dbqb"));
        $this->user = new User();
        $this->user->setDb($this->di->get("dbqb"));
        $this->tag = new Tag();
        $this->tag->setDb($this->di->get("dbqb"));
        $this->questionTag = new QuestionToTag();
        $this->questionTag->setDb($this->di->get("dbqb"));
        $this->comment = new Comment();
        $this->comment->setDb($this->di->get("dbqb"));
        $this->comThread = new CommentThread();
        $this->comThread->setDI($this->di);
    }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("osln/question/all", [
            "items" => $this->question->getAllPrintableArray($this->user, $this->tag, $this->questionTag),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }


    public function showAction($questionId) : object
    {
        $page = $this->di->get("page");
        $textfilter = $this->di->get("textfilter");

        $question = $this->question->getPrintableArray($questionId, $this->user, $this->tag, $this->questionTag);
        $sorted = $this->comThread->sortComments($questionId);

        $mainForm = new CreateCommentForm($this->di, null, $questionId);
        $mainForm->check();

        $data = [
            "question" => $question,
            "sortedComments" => $sorted,
            "mainForm" => $mainForm->getHTML(),
        ];
        $page->add("osln/question/thread", $data);

        return $page->render([
            "title" => "Create a item",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("osln/question/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di);
        $form->check();

        $page->add("question/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("question/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
