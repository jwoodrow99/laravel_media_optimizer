<?php

namespace jwoodrow99\laravel_video_optimizer\Jobs;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class OptimizeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $uploadFile;
    private $config;
    private $fileName;

    public function __construct(UploadedFile $file, $name, $config)
    {
        $this->uploadFile = $file;
        $this->config = [];
        $this->fileName = $name ?? uniqid() . '.' . $file->extension();

        $this->config['drive'] = $config['drive'] ?? config('laravel-media-optimizer.general.drive');
        $this->config['frame_rate'] = $config['frame_rate'] ?? config('laravel-media-optimizer.video.frame_rate');
        $this->config['resolution'] = $config['resolution'] ?? config('laravel-media-optimizer.video.resolution');
        $this->config['bit_rate'] = $config['bit_rate'] ?? config('laravel-media-optimizer.video.bit_rate');
        $this->config['audio_codec'] = $config['audio_codec'] ?? config('laravel-media-optimizer.video.audio_codec');
        $this->config['video_codec'] = $config['video_codec'] ?? config('laravel-media-optimizer.video.video_codec');
        $this->config['upload_dir'] = $config['upload_dir'] ?? config('laravel-media-optimizer.video.upload_dir');
        $this->config['compress_dir'] = $config['compress_dir'] ?? config('laravel-media-optimizer.video.compress_dir');
    }

    public function handle()
    {
        Storage::disk($this->config['drive'])->putFileAs($this->config['upload_dir'], $this->file, $this->fileName);

        $this->file = FFMpeg::fromDisk($this->config['drive'])->open($this->config['upload_dir'] . $this->fileName);

        $properties = $this->file->getVideoStream()->all();
        $properties['bit_rate'] = intval($this->file->getFormat()->get('bit_rate') / 1000);

        $format = new X264();                              // Change encoding to smallest format
        $format->setAudioCodec('libmp3lame');   // Changes audio Codec to compressed version
        $format->setVideoCodec('libx264');      // Changes video Codec to compressed version

        if ($properties['bit_rate'] > $this->config['bit_rate']){             // Checks if bitrate altering provides greater than 10%
            $format->setKiloBitrate($this->config['bit_rate']);
        }

        $resolutionWidth = $properties['width'];

        if ($resolutionWidth > $this->config['resolution']){
            $resolutionWidth = $properties['width'] / ($properties['height'] / $this->config['resolution']);
        }

        $this->file
            ->addFilter('-r', $this->config['frame_rate'])
            ->addFilter('-vf', 'scale='.$resolutionWidth.':'.$this->config['resolution'])
            ->export()
            ->toDisk($this->config['drive'])
            ->inFormat($format)
            ->save($this->config['compress_dir'] . $this->fileName);
    }
}
