<?php
// code sample for http://ffmpeg.unixpin.com
// #animation
// /korolev-ia@yandex

$output_height = 1080;
$output_width = 1920;
$duration = 5;
$filters = '';
$up_to = 1.05;
$output="pan_left.mp4";

$filters .= " [1:v] scale=w=1920:h=1080 [fg]; ";
$filters .= " [0:v] scale=w=-2:h=3*${output_height} , crop=w=3*${output_width}/$up_to:h=3*${output_height}/$up_to:x=t*(in_w-out_w)/$duration, ";
$filters .= " scale=w=${output_width}:h=${output_height}, ";
$filters .= " setsar=1 [bg] ;";
$filters .= " [bg][fg]overlay=shortest=1[v] ";
$cmd = "ffmpeg -y -loop 1 -i bgimage.png -ss 0 -t $duration -r 1 -loop 1 -i front.png -ss 0 -t $duration ";
$cmd .= "-filter_complex \"$filters\" -map \"[v]\" -c:v h264 -crf 18 -preset veryfast $output";
print $cmd;


exec($cmd);
