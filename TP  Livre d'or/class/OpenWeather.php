<?php
require_once __DIR__ . '/../exceptions/CurlException.php';
require_once __DIR__ . '/../exceptions/HttpException.php';
require_once __DIR__ . '/../exceptions/UnauthorizedHttpException.php';



/**
 * Gère l'API d'OpenWeather
 * 
 * @author Jonathan Boyer <john@ao.fr>
 */
class OpenWeather
{

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Récupère les informations météorologiques du jour
     * 
     * @param string $city Ville (ex: Montpellier,fr)
     * @return array|null
     */
    public function getToday(string $city): ?array
    {
        $data = $this->callAPI("weather?q=" . rawurlencode($city));
        return [
            'temp' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'date' => new DateTime()
        ];
    }

    /**
     * Récupère la météo ou les prévisions sur plusieurs jours
     * 
     * @param string $city Ville (ex: Montpellier,fr)
     * @return array|null
     */
    public function getForecast(string $city): ?array
    {
        $data = $this->callAPI("forecast?q=" . rawurlencode($city));
        $results = [];
        $days = [];
        foreach ($data['list'] as $item) {
            $date = (new DateTime('@' . $item['dt']))->format('Y-m-d');
            if (isset($days[$date])) {
                continue;
            }

            $days[$date] = true;
            $results[] = [
                'temp' => $item['main']['temp'],
                'description' => $item['weather'][0]['description'],
                'date' => new DateTime('@' . $item['dt'])
            ];
        }
        return $results;
    }

    /**
     * Appel l'API OpenWeather
     * 
     * @param string $endpoint L'action à appeler (ex: weather ou forecast)
     * @return array|null
     * @throws CurlException
     * @throws UnauthorizedException
     * @throws Exception
     */
    private function callAPI(string $endpoint): ?array
    {
        $curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}&units=metric&lang=fr&appid=" . rawurlencode($this->apiKey));
        $caFile = ini_get('curl.cainfo') ?: ini_get('openssl.cafile');
        if (!$caFile) {
            $caCandidates = [
                'C:\\Program Files\\MySQL\\MySQL Shell 8.0\\lib\\Python3.13\\Lib\\site-packages\\certifi\\cacert.pem',
                'C:\\Program Files (x86)\\Epic Games\\Launcher\\Engine\\Content\\Certificates\\ThirdParty\\cacert.pem'
            ];
            foreach ($caCandidates as $candidate) {
                if (is_file($candidate)) {
                    $caFile = $candidate;
                    break;
                }
            }
        }
        if ($caFile && is_file($caFile)) {
            curl_setopt($curl, CURLOPT_CAINFO, $caFile);
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        ]);
        $data = curl_exec($curl);
        if ($data === false) {
            $message = curl_error($curl);
            throw new CurlException($message);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($data, true);
        if ($status !== 200) {
            $message = $decoded['message'] ?? 'Impossible de récupérer la météo.';
            if ($status === 401) {
                throw new UnauthorizedHttpException($message);
            }
            throw new HttpException($message, $status);
        }

        if (!is_array($decoded)) {
            throw new HttpException('Réponse météo invalide.');
        }

        return $decoded;
    }
}
