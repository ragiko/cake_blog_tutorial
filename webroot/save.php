<?php

$data = $_REQUEST['RecordingUrl']; 

$keijban_file = 'a.txt';

$fp = fopen($keijban_file, 'ab');

if ($fp){
    if (flock($fp, LOCK_EX)){
        if (fwrite($fp,  $data) === FALSE){
            print('ファイル書き込みに失敗しました');
        }

        flock($fp, LOCK_UN);
    }else{
        print('ファイルロックに失敗しました');
    }
}
