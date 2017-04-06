<?php

function fn_comment_notify($file) {
    global $date, $site, $url;
    $comment = new Comment($file);
    $path = Path::F(Path::D($file), COMMENT);
    $state = Plugin::state(__DIR__);
    $from = Request::post('email');
    $to = $state['page']['email'];
    $subject = __replace__($state['page']['title'], [
        'site.title' => $site->title
    ]);
    $s = File::exist([PAGE . DS . $path . '.page', PAGE . DS . $path . '.archive']);
    $message = __replace__($state['page']['content'], [
        'comment.time' => $comment->time,
        'comment.url' => $comment->url,
        'comment.id' => $comment->id,
        'comment.author' => $comment->author . "",
        'comment.link' => $comment->link,
        'comment.content' => $comment->content,
        'page.title' => Page::open($s)->get('title', '?')
    ]);
    return !empty($to) ? Message::send($from, $to, $subject, $message) : false;
}

Hook::set('on.comment.set', 'fn_comment_notify');