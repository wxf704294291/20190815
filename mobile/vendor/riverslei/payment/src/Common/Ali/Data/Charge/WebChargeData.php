<?php
/**
 * @author: helei
 * @createTime: 2016-07-15 17:28
 * @description: 即时到帐 接口的数据处理类
 * @link      https://github.com/helei112g/payment/tree/paymentv2
 * @link      https://helei112g.github.io/
 */

namespace Payment\Common\Ali\Data\Charge;

use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * Class WebChargeData
 *
 * @inheritdoc
 * @property integer $qr_mod
 * @property string $paymethod
 *
 * @package Payment\Charge\Ali\Data
 * anthor helei
 */
class WebChargeData extends ChargeBaseData
{
    /**
     * 设置签名
     * @author helei
     */
    public function setSign()
    {
        $this->buildData();

        $values = ArrayUtil::removeKeys($this->retData, ['sign', 'sign_type']);

        $values = ArrayUtil::arraySort($values);

        $signStr = ArrayUtil::createLinkstring($values);

        $this->retData['sign'] = $this->makeSign($signStr);
    }

    /**
     * 构建 即时到帐 加密数据
     * @author helei
     */
    protected function buildData()
    {
        $content = [
            // 基本参数
            'service'   => $this->method,
            'partner'   => trim($this->partner),
            '_input_charset'   => trim($this->charset),
            'sign_type'   => $this->signType,// 这里仅支持rsa
            'notify_url'    => trim($this->notifyUrl),
            'return_url'    => trim($this->returnUrl),

            // 业务参数
            'out_trade_no'  => trim($this->order_no),
            'subject'   => trim($this->subject),
            'payment_type'  => 1,
            'total_fee' => trim($this->amount),
            'seller_id' => trim($this->partner),
            'body'  => trim($this->body),
            'paymethod' => $this->paymethod,// 默认采用余额支付
            'extra_common_param'    => urlencode($this->return_param),
            'qr_pay_mode'   => $this->qr_mod,
            'goods_type'    => $this->goods_type, //默认为实物类型
        ];

        $timeExpire = $this->timeout_express;
        if (! empty($timeExpire)) {
            $express = floor(($timeExpire - strtotime($this->timestamp)) / 60);
            $express && $content['it_b_pay'] = $express . 'm';// 超时时间 统一使用分钟计算
        }

        $limitPay = $this->limitPay;
        if ($limitPay) {
            $limitPay = explode(',', $limitPay);
            $content['disable_paymethod'] = implode('^', $limitPay);
        }

        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($content);
    }

    protected function getBizContent()
    {
        // TODO: Implement getBizContent() method.
    }

    protected function checkDataParam()
    {
        parent::checkDataParam(); // TODO: Change the autogenerated stub

        // paymethod
        $payMethod = $this->paymethod;
        $qrMod = $this->qr_mod;

        // 需要设置签名方式为Rsa  即时到账只支持该签名方式
        $this->signType = 'RSA';

        if (! empty($payMethod) && ! in_array($payMethod, ['creditPay', 'directPay'])) {
            throw new PayException('paymethod 仅支持： creditPay  directPay两种方式');
        }

        // 4的方式使用太复杂，暂时不处理
        if (! empty($qrMod) && ! in_array($qrMod, [0, 1, 2, 3])) {
            throw new PayException('qr_mod 仅支持： 0、1、2、3 几种方式');
        }
    }
}
