<?php

namespace App\Adapter;

use App\Traits\Container;
use GuzzleHttp\Client;

abstract class AdapterAbstract
{
    use Container;

    /** @var \Doctrine\Persistence\ObjectManager */
    protected $entityManager;

    /**
     * AbstractProvider2 constructor.
     */
    public function __construct()
    {
        $this->entityManager = self::$container->get('doctrine')->getManager();
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendRequest(array $data): array
    {
        $option = [];
        if (!empty($data['body'])) {
            $option = [
                'json' => $data['body'],
            ];
        }

        $client = new Client();
        $response = $client->request($data['request']['method'], $data['request']['url'], $option);

        return json_decode($response->getBody(), 1);
    }
}
