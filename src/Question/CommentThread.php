<?php

namespace Osln\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Osln\User\User;
use Osln\Question\HTMLForm\CreateCommentForm;
/**
 * A database driven model using the Active Record design pattern.
 */
class CommentThread implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    public function sortComments($questionId)
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $allComments = $comment->findAllWhere("question_id = ?", $questionId);
        $comments = $this->arrayify($allComments, $user);

        $allTrees = array();
        foreach ($comments as $comment) {
            if (is_null($comment["parent_comment_id"])) {
                $comment["children"] = $this->buildTree($comments, $comment["id"]);
                $allTrees[] = $comment;
            }
        }
        return $allTrees;
    }

    private function buildTree($comments, $parentId = 0)
    {
        $branch = array();
        foreach ($comments as $comment) {
            if ($comment["parent_comment_id"] == $parentId) {
                $children = $this->buildTree($comments, $comment["id"]);
                if ($children) {
                    $comment["children"] = $children;
                }
                $branch[] = $comment;
            }
        }
        return $branch;
    }

    private function arrayify($comments, $user)
    {
        $textfilter = $this->di->get("textfilter");
        $newArr = array();
        foreach ($comments as $comment) {
            $form = new CreateCommentForm(
                $this->di,
                $comment->id,
                $comment->question_id
            );
            $form->check();
            $acronym = $user->findWhere("id = ?", $comment->user_id);
            $commentArr = [
                "id" => $comment->id,
                "created" => $comment->created,
                "content" => $textfilter->markdown($comment->content),
                "user_id" => $comment->user_id,
                "acronym" => $acronym->acronym,
                "parent_comment_id" => $comment->parent_comment_id,
                "question_id" => $comment->question_id,
                "comment_form" => $form->getHTML(),
            ];
            $newArr[] = $commentArr;
        }
        return $newArr;
    }
}
