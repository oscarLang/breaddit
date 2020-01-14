<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Breaddit",
            "url" => "",
            "title" => "Breaddit.",
        ],
        [
            "text" => "Questions",
            "url" => "question",
            "title" => "All questions.",
        ],
        [
            "text" => "Tags",
            "url" => "tag",
            "title" => "All tags.",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "About this page.",
        ],
    ],
];
