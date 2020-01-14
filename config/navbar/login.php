<?php

/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",    // Here comes the menu items
    "items" => [
        [
            "text" => "User",
            "url" => "user/",
            "title" => "User",
            "submenu" => [
                "items" => [
                    [
                        "text" => "My Profile",
                        "url" => "user/",
                        "title" => "Profile.",
                    ],
                    [
                        "text" => "Logout",
                        "url" => "user/logout",
                        "title" => "Bye",
                    ],
                ],
            ],
        ],
    ],
];
