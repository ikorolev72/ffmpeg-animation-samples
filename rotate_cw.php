<?php
// code sample for http://ffmpeg.unixpin.com
// #animation
// /korolev-ia@yandex


$output_height = 1080;
$output_width = 1920;
$duration = 5;
$filters = '';
$angle = M_PI / 8; // in radians
$output = "rotate_cw.mp4";
$up_to = 2*sqrt( pow( $output_height/2,2 ) +  pow( $output_width/2,2 ) ) ;

$filters .= " [1:v] scale=w=1920:h=1080 [fg]; ";
$filters .= " [0:v] scale=w='if( gt(iw, ih), -2, $up_to )':h='if( gt(iw,ih), $up_to, -2  )', rotate=a=$angle*t/$duration:c=black:ow=$output_width:oh=$output_height, setsar=1 [bg]; ";
$filters .= " [bg][fg]overlay=shortest=1[v] ";
$cmd = "ffmpeg -y -loop 1 -i bgimage.png -ss 0 -t $duration -r 1 -loop 1 -i front.png -ss 0 -t $duration ";
$cmd .= "-filter_complex \"$filters\" -map \"[v]\" -c:v h264 -crf 18 -preset veryfast $output";
print $cmd;

exec($cmd);
