<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Controller for question.",
            "mount" => "question",
            "handler" => "\Osln\Question\QuestionController",
        ],
        [
            "info" => "Controller for tags.",
            "mount" => "tag",
            "handler" => "\Osln\Tag\TagController",
        ],
    ]
];
