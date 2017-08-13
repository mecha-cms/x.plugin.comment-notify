<?php

return [
    'page' => [
        'title' => '%{site.title}% · New Comment', // email subject
        'email' => 'email@domain.com', // your email address
        'content' => '<p style="font-size:150%;">%{comment.author}% » <a href="%{comment.url}%" target="_new">%{page.title}%</a></p>%{comment.content}%' // email message
    ]
];