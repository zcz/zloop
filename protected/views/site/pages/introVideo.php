<?php

//download.php
//content type
header('Content-type: text/plain');
//open/save dialog box
header('Content-Disposition: attachment; filename="zloopVideo.mov"');
//read from server and write to buffer
readfile('ftp://zloop.net/zloop_hksec/zloop3.mov');