<?php
/**
 * Created by ${PRODUCT_NAME}.
 * User: ${USER}
 * Date: ${DATE}
 * Time: ${TIME}
 * SVN: date:$Date: 2015-10-26 12:29:00 +0800 (Mon, 26 Oct 2015) $ author:$Author: pengzhan $
 * FILE:$HeadURL
 */
class FrameWorkConf
{
    const VERSION = '#203';
    //数据库日志是否打开
    const DB_LOG_OPEN = false;

    //日志级别

    const LOG_LEVEL = Logger::L_ALL;
    
    //是否是演示版
    const IS_SHOW = true;

    //是否是快餐模式
    const SNACK_MODEL = false;

    //总订单号分割依据,
    /**
     * 订单的四种状态
     *  const CREATE = 0;
     *  const CONFIRM = 1;
     *  const PAYING = 2;
     *  const DONE = 3;
     *  const CLEAR = 4;
     *  const ANTI_PAY = 5
     */
    const SUM_ID_DIVISION_ORDER_STATUS = 3;
    
    //会员卡结账是否从云端扣除数据
    const VIP_GOLD_SUB = true;

    //确认订单时候是否打印账单
    const BILL_PRINT_CONFIRMING = false;

    const EVENT_URL = 'http://wifidc.cn:8888/wingadevice/api/rest/event';

    const VERSION_UPDATE_HOST = 'http://wanda.winga.cn:9091';

}