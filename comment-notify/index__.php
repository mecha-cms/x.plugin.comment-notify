<?php

function fn_comment_notify($file) {
    if (Message::$x) {
        return $file; // There are some error(s) in the form
    }
    global $site, $url;
    // Delay sending the email notice after we create the comment file…
    Hook::set('guardian.kick.before', function($long) use($file, $site, $url) {
        $path = Path::F(Path::D($file), COMMENT);
        $o = [
            'page' => new Page(File::exist([
                PAGE . DS . $path . '.page',
                PAGE . DS . $path . '.archive'
            ], null)),
            'comment' => new Comment($file)
        ];
        $state = Plugin::state(__DIR__);
        $from = Request::post('email');
        $to = $state['page']['email'];
        $subject = __replace__($state['page']['title'], [
            'title' => To::text($site->title)
        ]);
        foreach ([
            'comment' => ['author', 'content', 'email', 'id', 'link', 'status', 'time', 'url'],
            'page' => ['description', 'title']
        ] as $k => $v) {
            foreach ($v as $kk => $vv) {
                $message = __replace__($state['page']['content'], [
                    $k . '.' . $vv => $o[$k]->{$vv}
                ]);
            }
        }
        if (!empty($to)) {
            Message::send($from, $to, $subject, $message);
        }
        return $long;
    });
    return $file;
}

Hook::set('on.comment.set', 'fn_comment_notify');