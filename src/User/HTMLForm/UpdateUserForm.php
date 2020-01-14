<?php

namespace Osln\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Osln\User\User;

/**
 * Form to update an item.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Please input your password to confirm",
                    "validation" => ["not_empty"],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return User
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $email         = $this->form->value("email");
        $password      = $this->form->value("password");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));
        var_dump($user);
        if (!password_verify($password, $user->password)) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user->email = $email;
        $user->generateGravatar($email);
        $user->save();
        $session = $this->di->get("session");
        $loggedInUser = [
            "id" => $user->id,
            "acronym" => $user->acronym,
            "gravatar" => $user->gravatar
        ];
        $session->set("user", $loggedInUser);
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $session = $this->di->get("session");
        $session->set("message", "User updated");
        $this->di->get("response")->redirect("user")->send();
        //$this->di->get("response")->redirect("question/update/{$question->id}");
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
