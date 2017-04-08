<?php

return [
    'page' => [
        'title' => '%{site.title}% · New Comment', // email subject
        'email' => 'email@domain.com', // your email address
        'content' => '<h3>%{comment.author}% » <a href="%{comment.url}%">%{page.title}%</a></h3>%{comment.content}%' // email message
    ]
];