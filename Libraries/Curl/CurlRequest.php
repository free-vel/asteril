<?php
namespace Libraries\Curl;

class CurlRequest
{
    public $ch;

    public function __construct() {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    }

    public function get($url, $header = null): bool|string
    {
        $options = [];
        if ($header)
        {
            $options[CURLOPT_HTTPHEADER] = $header;
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt_array($this->ch, $options);

        return curl_exec($this->ch);
    }

    function multipleThreadsRequest($nodes, $header = null): array
    {
        $header = $header ?? array('Content-Type: application/json');

        $mh = curl_multi_init();
        $curl_array = array();

        foreach($nodes as $i => $node)
        {
            $curl_array[$i] = curl_init();

            $options = array(
                CURLOPT_URL => $node['url'],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $node['params']
            );
            if ($header)
            {
                $options[CURLOPT_HTTPHEADER] = $header;
            }
            curl_setopt_array($curl_array[$i], $options);

            curl_multi_add_handle($mh, $curl_array[$i]);
        }

        $running = NULL;
        do {
            usleep(10000);
            curl_multi_exec($mh,$running);
        } while($running > 0);

        $res = array();

        foreach($nodes as $i => $node)
        {
            $res[$node['url']] = curl_multi_getcontent($curl_array[$i]);
        }

        foreach($nodes as $i => $node){
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }

        curl_multi_close($mh);

        return $res;
    }

}