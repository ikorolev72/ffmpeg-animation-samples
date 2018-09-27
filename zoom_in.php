<?php
// code sample for http://ffmpeg.unixpin.com
// #animation
// /korolev-ia@yandex

$output_height = 1080;
$output_width = 1920;
$zoompan_up_to = 1.1;
$duration = 5;
$filters = '';

$zoom_delta = ($zoompan_up_to - 1) / 25 / $duration;
$zooming_output = $output_width . "x" . $output_height;

$filters .= " [1:v] scale=w=1920:h=1080 [fg]; ";
$filters .= " scale=w=-2:h=3*${output_height} , crop=w=3*${output_width}:h=3*${output_height}, ";
$filters .= " zoompan=z=min(max(zoom\,pzoom)+$zoom_delta\,$zoompan_up_to):d=1:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=${output_width}x${output_height}, ";
$filters .= " setsar=1 [bg]; ";
$filters .= " [bg][fg]overlay=shortest=1[v] ";
$cmd = "ffmpeg -y -loop 1 -i bgimage.png -ss 0 -t $duration -r 1 -loop 1 -i front.png -ss 0 -t $duration ";
$cmd .= "-filter_complex \"$filters\" -map \"[v]\" -c:v h264 -crf 18 -preset veryfast out.mp4";
print $cmd;


exec($cmd);
