<?php

namespace Osln\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Osln\User\HTMLForm\UserLoginForm;
use Osln\User\HTMLForm\UpdatePasswordForm;
use Osln\User\HTMLForm\UpdateUserForm;
use Osln\User\HTMLForm\CreateUserForm;
use Osln\Tag\QuestionToTag;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $resp = $this->di->get("response");
        if ($session->has("user")) {
           return $resp->redirect("user/show/" . $session->get("user")["acronym"]);
        } else {
            return $resp->redirect("user/login");
        }
    }

    public function showActionGet(string $username) : object
    {
        // TODO: user/show/username
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $questionToTag = new QuestionToTag();
        $questionToTag->setDb($this->di->get("dbqb"));
        $all = $questionToTag->findAllQuestionsByUsername($username);

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->findWhere("acronym = ?", $username);

        $data = [
            "items" => $all,
            "user" => $user,
            "userSession" => $session->has("user") ? $session->get("user") : null,
            "flashmessage" => $session->get("message"),
        ];
        $session->delete("message");
        $page->add("osln/user/user", $data);
        return $page->render();
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $succes = $form->check();

        $page->add("osln/user/login", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }

    public function logoutAction() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $resp = $this->di->get("response");
        $session->delete("user");
        return $resp->redirect("user/login");
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function updatepassAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdatePasswordForm($this->di, $id);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an user",
        ]);
    }

    public function updateuserAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an user",
        ]);
    }

    // public function topAction() : object
    // {
    //
    // }
}
