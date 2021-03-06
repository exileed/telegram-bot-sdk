<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * Class PassportFile.
 *
 * @method string     getFileId()   Unique file identifier.
 * @method int        getFileSize() (Optional). File size.
 * @method int        getFileDate() (Optional). Unix time when the file was uploaded.
 */
class PassportFile extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
