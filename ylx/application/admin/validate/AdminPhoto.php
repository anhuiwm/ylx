<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminPhoto extends Validate{

	protected $rule = array(
		'userid'      		=> 'require',
	);
	protected $message = array(
		'userid.require'    		=> 'userid必须填写',
	);
}