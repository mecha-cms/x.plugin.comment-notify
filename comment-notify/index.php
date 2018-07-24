<?php

function fn_comment_notify($file) {
    if (Message::$x) {
        return $file; // There are some error(s) in the form, skip!
    }
    global $date, $language, $site, $url;
    // Delay sending the email notice after we create the comment file…
    Hook::set('guardian.kick', function() use($file, $date, $language, $site, $url) {
        $path = Path::F(Path::D($file), COMMENT);
        $o = [
            'comment' => new Comment($file),
            'config' => $site,
            'date' => $date,
            'language' => $language,
            'page' => new Page(File::exist([
                PAGE . DS . $path . '.page',
                PAGE . DS . $path . '.archive'
            ], null)),
            'site' => $site,
            'url' => $url,
            'u_r_l' => $url
        ];
        $state = Plugin::state('comment-notify');
        $from = HTTP::post('email');
        $to = $state['page']['email'];
        $subject = To::text(__replace__($state['page']['title'], $o));
        $message = To::text(__replace__($state['page']['content'], $o), HTML_WISE_I . ',p', true);
        if (!empty($to)) {
            Message::send($from, $to, $subject, $message);
        }
    });
    return $file;
}

Hook::set('on.comment.set', 'fn_comment_notify');