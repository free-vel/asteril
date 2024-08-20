<?php
namespace Libraries\Asteril;

use Libraries\Curl\CurlRequest;

class Asteril
{
    private array $apiParams;
    const PAGE_LIMIT = 10;
    private CurlRequest $curlRequest;

    public function __construct($apiParams)
    {
        $this->apiParams = $apiParams;
        foreach($this->apiParams as &$item){
            $item = trim($item, '/');
        }

        $this->curlRequest = new CurlRequest();
    }

    /**
     * @param array $params
     * @param $page
     * @return bool|string
     */
    public function getOrders(array $params, $page = null)
    {
        if($page) $params['page'] = $page;
        $params['limit'] = self::PAGE_LIMIT;

        $curlOptUrl = 'https://'.$this->apiParams['subdomain'].'.asteril.com/'.$this->apiParams['apiGetOrdersUrl'].'?api_key='.$this->apiParams['apiKey'];
        $curlOptUrl .= '&'.http_build_query($params);

        return $this->curlRequest->get($curlOptUrl);
    }

    /**
     * @param array $orders
     * @return void
     */
    public function updateOrders(array $orders): void
    {
        $orders = $this->prepareOrdersForUpdate($orders);
        $this->curlRequest->multipleThreadsRequest($orders);
    }

    /**
     * @param array $orders
     * @return array
     */
    private function prepareOrdersForUpdate(array $orders): array
    {
        foreach($orders as &$order){
            $order['url'] = 'https://'.$this->apiParams['subdomain'].'.asteril.com/'.$this->apiParams['apiUpdateOrderUrl'].'/'.$order['id'].'?api_key='.$this->apiParams['apiKey'];
            $data = [
                'fields' => $order['fields']
            ];
            $order['params'] = json_encode($data);
        }

        return $orders;
    }

    /**
     * @param array $orders
     * @param array $changeCriteria
     * @return array
     */
    public function compareOrdersAndCriteria(array $orders, array $changeCriteria): array
    {
        $ordersForChange = [];

        foreach($orders as $order){
            foreach($changeCriteria as $item){
                $criteria = json_decode($item['criteria'], true);
                $changes = json_decode($item['changes'], true);
                if($order['order_type'] == $criteria['order_type']){
                    $intersectArray = array_intersect_assoc($order, $criteria['additional']);
                    $newStatus = $changes['not_matched_status'];
                    if(count($intersectArray) === count($criteria['additional'])){
                        $newStatus = $changes['matched_status'];
                    }
                    $ordersForChange[] = array(
                        'id' => $order['id'],
                        'fields' => [
                            'status' => $newStatus
                        ]
                    );
                }
            }
        }

        return $ordersForChange;
    }

}
