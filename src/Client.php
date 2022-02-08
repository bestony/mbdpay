<?php

namespace Bestony\Mbdpay;

class Client
{
    private $appid, $appkey;

    public function __construct($appid, $appkey)
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
    }

    
    public function wxH5pay($ops = []) {
        $ops["channel"] = "h5";
        $ops["app_id"] = $this->appid;
        $ops["sign"] = $this->signData($ops);
        $res = $this->request('https://api.mianbaoduo.com/release/wx/prepay', $ops);
        return $res;
    }

    public function wxJSPay($ops = []) {
        $ops['app_id'] = $this->appid;
        $ops['sign'] = $this->signData($ops);
        $res = $this->request('https://api.mianbaoduo.com/release/wx/prepay', $ops);
        return $res;
    }

    public function aliPay($ops = []) {
        $ops['app_id'] = $this->appid;
        $ops['sign'] = $this->signData($ops);
        $res = $this->request('https://api.mianbaoduo.com/release/alipay/pay', $ops);
        return $res;
    }

    public function refund($ops = []) {
        $ops['app_id'] = $this->appid;
        $ops['sign'] = $this->signData($ops);
        $res = $this->request('https://api.mianbaoduo.com/release/main/refund', $ops);
        return $res;
    }


    public function searchOrder($ops = []) {
        $ops["app_id"] = $this->appid;
        $ops["sign"] = $this->signData($ops);
        $res = $this->request("https://api.mianbaoduo.com/release/main/search_order",$ops);
        return $res;
    }

    /**
     * 获取用户 OpenID
     *
     * @param string $targetUrl 跳转后的地址，假设地址为 http://www.example.com/abc?uid=32，登录完成后，会访问到 http://www.example.com/abc?uid=32&openid=*************
     *
     * @return string 生成的可跳转的 URL，需要在微信客户端内让用户跳转，或生成二维码，让用户自行跳转。
     */
    public function getOpenIdUrl($targetUrl): string
    {
        return "https://mbd.pub/openid" . "?" . http_build_query([
                "target_url" => $targetUrl,
                "app_id" => $this->appid,
            ]);
    }


    private function request($url, $data)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $bodyJSON = json_encode($data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJSON);

        $response = curl_exec($ch);
        if (!$response) {
            return [
                "error"=>"Network Error",
                "msg" => curl_error($ch) ,
                "code" => curl_errno($ch)
            ];
        }
        curl_close($ch);

        return json_decode($response,true);
    }

    /**
     * 计算数据签名
     *
     * @param array $data 需要计算签名的数据
     *
     * @return string 计算好的签名
     */
    private function signData($data)
    {
        ksort($data);
        $sign = md5(urldecode(http_build_query($data)) . '&key=' . $this->appkey);
        return $sign;
    }
}