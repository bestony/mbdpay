<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    private $appid;
    private $appkey;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->appid = getenv("APPID");
        $this->appkey=  getenv("APPKEY");
        $this->client = new \Bestony\Mbdpay\Client($this->appid, $this->appkey);
    }

    /**
     * 测试生成获取 OpenID 的 URL；
     * @return
     */
    public function testCanGetOpenIDUrl(){
        $result = $this->client->getOpenIdUrl("http://baidu.com");

        $this->assertMatchesRegularExpression('/baidu.com/',$result);
        $this->assertMatchesRegularExpression('/'.$this->appid.'/',$result);
    }

    /**
     * 测试搜索订单
     */
    public  function testCanSearchOrder(){
        $okResult = $this->client->searchOrder([
            "out_trade_no" => "b172ca9114a9a85899519433151f1e6e"
        ]);
        $this->assertArrayHasKey('charge_id', $okResult);
        $this->assertArrayHasKey('description', $okResult);
        $this->assertArrayHasKey('share_id', $okResult);
        $this->assertArrayHasKey('share_state', $okResult);
        $this->assertArrayHasKey('state', $okResult);
        $this->assertArrayHasKey('create_time', $okResult);
        $this->assertArrayHasKey('payway', $okResult);
        $this->assertArrayHasKey('callback_url', $okResult);
        $this->assertArrayHasKey('plusinfo', $okResult);
        $this->assertArrayHasKey('update_time', $okResult);

        $failResult = $this->client->searchOrder([
            'out_trade_no' => 'abc'
        ]);
        $this->assertArrayHasKey('error', $failResult);
    }

    public function testCanUseWXH5Pay(){
        $okResult = $this->client->wxH5pay([
            "description" => "testDescription",
            "out_trade_no" => "1234ajs".mt_rand(),
            "amount_total" => 1
        ]);
        $this->assertArrayHasKey("h5_url", $okResult);
    }

    public function testCanUseWXJSPay()
    {
        $failResult = $this->client->wxJSPay([
            'description' => 'testDescription',
            'amount_total' => 1,
            'openid' => 123,
            'callback_url' => 'https://www.baidu.com'
        ]);
        $this->assertArrayHasKey('message', $failResult);
        $this->assertArrayHasKey('code', $failResult);
        $this->assertArrayHasKey('detail', $failResult);
    }
    public  function testCanUseAlipay(){
        $okResult = $this->client->aliPay([
            'url' => "https://baidu.com",
            'description' => 'test-product',
            'amount_total' =>  1,
            'callback_url' => "https://baidu.com"
        ]);
        $this->assertArrayHasKey("body",$okResult);
    }

    public function testCanUseRefund()
    {
        $okResult = $this->client->refund([
            "order_id" => "b172ca9114a9a85899519433151f1e6e"
        ]);
        $this->assertArrayHasKey("error", $okResult);
    }
}