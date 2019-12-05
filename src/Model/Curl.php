<?php

namespace Linder\Model;

/**
 * A model class retrievieng data from an external server.
 */
class Curl
{
    /**
     * Function that takes an api url and returns the result as a decoded json.
     *
     * @param string $url
     *
     * @return array $result
     */
    public function single(String $url) : array
    {

        // Setup options
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url
        ];
        //  Initiate curl handler
        $ch = curl_init();
        // Set options
        curl_setopt_array($ch, $options);
        // Execute
        $data = curl_exec($ch);
        // Closing
        curl_close($ch);
        $res = json_decode($data, true);

        return $res;
    }

    /**
     * Function that takes multiple api urls and returns the result as a decoded json.
     *
     * @param array $urls
     *
     * @return array $result
     */
    public function multi(Array $urls) : array
    {
        // Setup options
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
        ];
        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        foreach ($urls as $url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }
        return $response;
    }
}
