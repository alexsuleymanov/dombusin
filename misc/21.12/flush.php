<?php
ob_implicit_flush(1);
for($i=0; $i<10; $i++){
    echo $i;
    echo str_repeat(' ',1024*64);
    sleep(1);
}

