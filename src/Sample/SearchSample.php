<?php

namespace DmmSearch\Sample;

use Dmm\Apis\Product;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dmm\Dmm;
use Dmm\DmmClient;
use Dmm\Exceptions\DmmSDKException;

/**
 * Class SearchSample
 * @package DmmSearch\Sample
 */
class SearchSample
{
    /**
     * @var DmmClient
     */
    protected $client;

    /**
     * SearchSample constructor.
     *
     * @param string $appId
     * @param string $affiliate_id
     */
    public function __construct(string $appId, string $affiliate_id)
    {
        try {
            // 別クラスでやるべき
            $logger = new Logger('DMM_SEARCH');
            $handler = new StreamHandler('./app.log', Logger::DEBUG);
            $logger->pushHandler($handler);

            // スーパークラスでやるべき
            $this->client = new Dmm([
                'api_id' => $appId,
                'affiliate_id' => $affiliate_id,
            ]);
        } catch (\Exception | DmmSDKException $e) {
            // 例外を記録する
            $logger->error($e->getMessage());
        }
    }

    /**
     * 検索ワードから商品情報を取得する
     *
     * @param string $keyword
     * @return array
     */
    public function getSearchItemsByKeyword(string $keyword): array
    {
        $response = $this->client->api('product')->find(Product::SITE_GENERAL, [
            'keyword' => $keyword,
        ]);
        return $response->getDecodedBody();
    }
}
