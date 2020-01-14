<?php

namespace Osln\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));

        $page->add("osln/tag/all", [
            "items" => $tag->findAll(),
        ]);

        return $page->render([
            "title" => "All tags",
        ]);
    }

    public function showAction($tagId) : object
    {
        $page = $this->di->get("page");
        $questionToTag = new QuestionToTag();
        $questionToTag->setDb($this->di->get("dbqb"));
        $allQuestions = $questionToTag->findAllQuestionsByTag($tagId);
        // var_dump($allQuestions);
        $data = [
            "tagId" =>$tagId,
            "questions" => $allQuestions,
        ];
        $page->add("osln/tag/show", $data);

        return $page->render([
            "title" => "tag " . $tagId,
        ]);
    }
}
