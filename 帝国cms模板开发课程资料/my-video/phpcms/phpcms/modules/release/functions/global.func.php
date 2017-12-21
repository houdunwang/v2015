<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 删除30天前的消息队列
 */
function del_queue() {
	$times = SYS_TIME-2592000;
	$queue = pc_base::load_model('queue_model');
	$queue->delete("times <= $times");
}