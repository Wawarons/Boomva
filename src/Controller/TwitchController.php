<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwitchController extends AbstractController
{

    private function getOauthToken() {
        
        $secret = $_ENV['CLIENT_SECRET'];
        $clientId = $_ENV['CLIENT_ID'];
        $client = new Client();
        $response = $client->request("POST", "https://id.twitch.tv/oauth2/token?client_id=". $clientId ."&client_secret=". $secret . "&grant_type=client_credentials", [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
                ]
        ]);
        
        $token = json_decode($response->getBody(), true);
        return $token;
    }

    #[Route('/streams', name: 'app_twitch')]
    public function getStreams(): Response
    {
        $clientId = $_ENV['CLIENT_ID'];
        $token = $this->getOauthToken();
        
        $client = new Client();
        $response = $client->request(
            "GET",
            "https://api.twitch.tv/helix/streams?first=99",
            ['headers' => [
                'Authorization' => 'Bearer ' . $token['access_token'],
                'Client-Id' => $clientId
            ]],
        );

        $data = json_decode($response->getBody(), true);
        $streams = $data['data'];

        return $this->render('twitch/index.html.twig', [
            'streams' => $streams,
        ]);
    }
}
