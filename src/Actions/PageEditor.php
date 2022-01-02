<?php

namespace AnywhereMedia\PageEditor\Actions;

use TCG\Voyager\Actions\AbstractAction;

class PageEditor extends AbstractAction
{
    public function getTitle()
    {
        return 'Design';
    }

    public function getIcon()
    {
        return 'voyager-edit';
    }

    public function getPolicy()
    {
        return 'edit';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
            'style' => 'margin-right:5px;'
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'pages';
    }

    public function getDefaultRoute()
    {
        return 'page-editor/build?page=' . $this->data->{$this->data->getKeyName()};
    }
}