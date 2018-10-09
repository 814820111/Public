<?php
/**
 * 
 * 回调基础类
 * @author widyhu
 *
 */
class WxPayNotify extends WxPayNotifyReply
{
	/**
	 * 
	 * 回调入口
	 * @param bool $needSign  是否需要签名输出
	 */
	final public function Handle($needSign = true)
	{
		file_put_contents('./logs/log_wx.txt', date('Y-m-d H:i:s')."：start");
		$msg = "OK";
		//当返回false的时候，表示notify中调用NotifyCallBack回调失败获取签名校验失败，此时直接回复失败
		$result = WxpayApi::notify(array($this, 'NotifyCallBack'), $msg);
		if($result == false){
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
			$this->ReplyNotify(false);
			return;
		} else {
			//该分支在成功回调到NotifyCallBack方法，处理完成之后流程
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		}
		$this->ReplyNotify($needSign);
	}
	
	/**
	 * 
	 * 回调方法入口，子类可重写该方法
	 * 注意：
	 * 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
	 * 2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
	 * @param array $data 回调解释出的参数
	 * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	/*
	public function NotifyProcess($data, &$msg)
	{
		//TODO 用户基础该类之后需要重写该方法，成功的时候返回true，失败返回false
		return true;
	}
	*/
	/**
	 * 
	 * notify回调方法，该方法中需要赋值需要输出的参数,不可重写
	 * @param array $data
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	final public function NotifyCallBack($data)
	{
		$msg = "OK";
		$result = $this->NotifyProcess($data, $msg);
		if($result == true){
			if ($data["result_code"] == "SUCCESS" && $data["return_code"] == "SUCCESS" && $data["out_trade_no"]) {
				/*
				$mysql_server_name      = "123.57.58.205";              //数据库服务器名称
				$mysql_username         = "root";                       // 连接数据库用户名
				$mysql_password         = "Sp881020";                   // 连接数据库密码
				$mysql_database         = "xunpai";                     // 数据库的名字
				*/
				$mysql_server_name      = "115.28.37.140";              //数据库服务器名称
				$mysql_username         = "xunpai";                       // 连接数据库用户名
				$mysql_password         = "123456";                   // 连接数据库密码
				$mysql_database         = "xunpai";                     // 数据库的名字
				// 连接到数据库
				$conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
				// 修改订单状态
				$os_sql = "update x_orders set state=2 where order_num = '" . $data["out_trade_no"] . "'";
				mysql_db_query($mysql_database, $os_sql, $conn);

				//  查询订单信息
				$oinfo = "select * from x_orders where order_num = '" . $data["out_trade_no"] . "'";
				$res_sql = mysql_db_query($mysql_database, $oinfo, $conn);
				$row = mysql_fetch_row($res_sql);

				$oginfo = "select * from x_orders_goods where orders_id = " . $row[0];
				$ogres_sql = mysql_db_query($mysql_database, $oginfo, $conn);
				$ogrow = mysql_fetch_row($ogres_sql);

				$opinfo = "update x_p1_goods set surplus=(surplus-1) where id = " . $ogrow[2];
				mysql_db_query($mysql_database, $opinfo, $conn);
				// 判断优惠券   有：修改状态 
				if ($row[5]) {
					$ocinfo = "update x_orders_coupons set state=2 where id = '" . $row[5] . "'";
					mysql_db_query($mysql_database, $ocinfo, $conn);
				}
			}
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		} else {
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
		}
		return $result;
	}
	
	/**
	 * 
	 * 回复通知
	 * @param bool $needSign 是否需要签名输出
	 */
	final private function ReplyNotify($needSign = true)
	{
		//如果需要签名
		if($needSign == true && 
			$this->GetReturn_code($return_code) == "SUCCESS")
		{
			$this->SetSign();
		}
		WxpayApi::replyNotify($this->ToXml());
	}
}
