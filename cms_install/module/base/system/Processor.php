<?php namespace module\base\system;

use Db;
use module\base\model\BaseContent;
use module\HdProcessor;
use WeChat;

class Processor extends HdProcessor
{
    public function handler($kid)
    {
        $id = $this->getModuleId($kid);
        $this->text(BaseContent::find($id)->content);
    }
}