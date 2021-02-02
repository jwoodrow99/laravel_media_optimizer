<?php

return [
    'general' => [
        'drive' => env('MEDIA_OPTIMIZER_DRIVER', config('filesystems.default'))
    ],
    'image' => [],
    'video' => [
        'frame_rate' => env('MEDIA_OPTIMIZER_VIDEO_FRAME_RATE', '24'),
        'resolution' => env('MEDIA_OPTIMIZER_VIDEO_RESOLUTION', '720'),
        'bit_rate' => env('MEDIA_OPTIMIZER_VIDEO_BIT_RATE', '1000'),
        'audio_codec' => env('MEDIA_OPTIMIZER_VIDEO_AUDIO_CODEC', 'libmp3lame'),
        'video_codec' => env('MEDIA_OPTIMIZER_VIDEO_VIDEO_CODEC', 'libx264'),
        'upload_dir' => env('MEDIA_OPTIMIZER_VIDEO_UPLOAD_DIR', 'optimize/videos/uploads/'),
        'compress_dir' => env('MEDIA_OPTIMIZER_VIDEO_COMPRESS_DIR', 'optimize/videos/compressed/')
    ],
];
