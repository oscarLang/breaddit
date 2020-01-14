<?php

namespace Osln\Index;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Osln\User\User;
use Osln\Question\Question;
use Osln\Question\Comment;
use Osln\Question\CommentThread;
use Osln\Tag\Tag;
use Osln\Tag\QuestionToTag;
// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IndexController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



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
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {

        $page = $this->di->get("page");
        $textfilter = $this->di->get("textfilter");

        $page->add("osln/index/index", [
            "items" => $this->question->getLatestArray($this->user, $this->tag, $this->questionTag),
        ]);

        $page->add("osln/index/top-user", [
            "items" => $this->user->findTop(),
        ]);

        $page->add("osln/index/top-tag", [
            "items" => $this->tag->findTop(),
        ]);

        return $page->render([
            "title" => "Breaddit",
        ]);
    }

    public function aboutAction() : object
    {
        $content = $this->di->get("content");
        $page = $this->di->get("page");
        try {
            $fileContent = $content->contentForRoute("about");
        } catch(NotFoundException $e) {
            return false;
        }
        foreach ($fileContent->views as $view) {
            $page->add($view);
        }
        return $page->render($fileContent->frontmatter);
    }
}
