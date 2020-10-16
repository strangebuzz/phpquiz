<?php
foreach ([true, true] as $cond) if ($cond) :
    while (--$cond) {
        echo 'foo';
        goto end;
    }
endif;
end: echo 'end';
