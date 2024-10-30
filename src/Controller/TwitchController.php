<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwitchController extends AbstractController
{
    private function getOauthToken() {
       // 
    }

    #[Route('/streams', name: 'app_twitch')]
    public function getStreams(): Response
    {
        $client = new Client();
        $response = $client->request(
            "GET",
            "https://api.twitch.tv/helix/streams",
            ['headers' => [
                'ClientId' => ''
            ]],
        );

        $data = json_decode($response->getBody(), true);
        $streams = $data['data'];

        return $this->render('twitch/index.html.twig', [
            'streams' => $streams,
        ]);
    }
}
