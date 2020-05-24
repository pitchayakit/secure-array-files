<?php

namespace MovexUkraine\SecureArrayFiles;

use Laravel\Nova\Fields\Field;

class SecureArrayFiles extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'secure-array-files';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * @param @disk
     * @return SecureArrayFiles
     */
    public function disk($disk)
    {
        return $this->withMeta(['disk' => $disk]);
    }

    /**
     * @param $path
     * @return SecureArrayFiles
     */
    public function path($path)
    {
        return $this->withMeta(['path' => $path]);
    }
}
