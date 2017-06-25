<?php namespace addons\links\system;

class Tag
{
    public function link($attr, $content)
    {
        $row = isset($attr['row']) ? $attr['row'] : 10;
        $php
             = <<<str
<?php
    \$data = Db::table('addon_link_data')->limit($row)->get();
    foreach(\$data as \$field):?>
    $content
    <?php endforeach;?>
str;

        return $php;
    }
}