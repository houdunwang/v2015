<?php namespace system\model;

/**
 * 卡券使用管理
 * Class TicketRecord
 *
 * @package system\model
 */
class TicketRecord extends Common
{
    protected $table = 'ticket_record';
    protected $allowFill = ['*'];
    protected $timestamps = true;

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
        ];
}