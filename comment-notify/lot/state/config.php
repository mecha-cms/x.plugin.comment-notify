<?php

return [
    'page' => [
        'title' => '%{site.title}% · New Comment', // email subject
        'email' => 'email@domain.com', // your email address
        'content' => '<p>A new comment has been added to <a href="%{comment.url}%">%{page.title}%</a>.</p>' // email message
    ]
];