<?php

function fn_comment_notify($file) {
    global $site, $url;
    // Delay sending the email notice after we create the comment file…
    Hook::set('guardian.kick.before', function($long) use($file, $site, $url) {
        $comment = new Comment($file);
        $path = Path::F(Path::D($file), COMMENT);
        $state = Plugin::state(__DIR__);
        $from = Request::post('email');
        $to = $state['page']['email'];
        $subject = __replace__($state['page']['title'], [
            'site.title' => To::text($site->title)
        ]);
        $s = File::exist([PAGE . DS . $path . '.page', PAGE . DS . $path . '.archive']);
        $page = Page::open($s)->get([
            'title' => '?',
            'description' => '?'
        ]);
        $message = __replace__($state['page']['content'], [
            'comment.time' => $comment->time,
            'comment.url' => $comment->url,
            'comment.id' => $comment->id,
            'comment.author' => $comment->author . "",
            'comment.email' => $comment->email,
            'comment.link' => $comment->link,
            'comment.status' => $comment->status,
            'comment.content' => $comment->content,
            'page.title' => $page['title'],
            'page.description' => $page['description']
        ]);
        if (!empty($to)) {
            Message::send($from, $to, $subject, $message);
        }
        return $long;
    });
    return $file;
}

Hook::set('on.comment.set', 'fn_comment_notify');