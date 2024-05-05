<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MapController implements ControllerInterface
{
    public function execute(Request $request): string|null
    {



        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://velib-metropole-opendata.smovengo.cloud/opendata/Velib_Metropole/station_information.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYPEER => false

        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response =  json_decode($response,true);

//        foreach ($response['data']['stations'] as $station) {
//            $latitude = $station['lat'];
//            $longitude = $station['lon'];
//
//            echo "Latitude: $latitude, Longitude: $longitude <br>";
//        }


//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo "<pre>";
//            var_dump(json_decode($response,true));
//            echo "<pre>";
//        }
        //echo $response['data']['stations'][0]['lat'];


        return TwigCore::getEnvironment()->render('map/map.html.twig',
            [
                "titre"   => 'MapController',
                "request" => $request,
                "response" => $response
            ]
        );
    }
}
