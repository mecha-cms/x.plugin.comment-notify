<?php

return [
    'page' => [
        'title' => '%{site.title}% · New Comment', // email subject
        'email' => 'email@domain.com', // your email address
        'content' => '<p><strong>%{comment.author}% » <a href="%{comment.url}%">%{page.title}%</a></strong></p>%{comment.content}%' // email message
    ]
];