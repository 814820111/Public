<?php
// 获取职位对应的权限等级
// 传入职位id，返回权限等级
function get_duty_level($duty_id){
	return M('duty')->where("id = $duty_id")->getField('level');
}
//传入职位id，获取职位名称
function get_duty_name($duty_id){
	return M('duty')->where("id = $duty_id")->getField('name');
}
// 传入科室id
// 传出科室名称
function get_department_name($departmentid){
	return M('department')->where("id = $departmentid")->getField('name');;
}