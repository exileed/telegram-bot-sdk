<?php

namespace Telegram\Bot\Objects;

/**
 * Class VideoNote.
 *
 *
 * @method string       getFileId()     Unique identifier for this file.
 * @method int          getDuration()   Duration of the video in seconds as defined by sender.
 * @method string       getMimeType()   (Optional). Mime type of a file as defined by sender.
 * @method PhotoSize    getThumb()      (Optional). Video thumbnail.
 * @method int          getFileSize()   (Optional). File size.
 */
class VideoNote extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
