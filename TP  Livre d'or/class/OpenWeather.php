<?php
require_once __DIR__ . '/../exceptions/CurlException.php';
require_once __DIR__ . '/../exceptions/HttpException.php';
require_once __DIR__ . '/../exceptions/UnauthorizedHttpException.php';

class OpenWeather {

    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get current weather
     */
    public function getToday(string $city): array
    {
        $data = $this->callAPI("weather?q={$city}");
        return [
            'temp'        => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'date'        => new DateTime()
        ];
    }

    /**
     * Get weather forecast
     */
    public function getForecast(string $city): array
    {
        $data = $this->callAPI("forecast/daily?q={$city}");
        $results = [];
        foreach ($data['list'] as $day) {
            $results[] = [
                'temp'        => $day['temp']['day'],
                'description' => $day['weather'][0]['description'],
                'date'        => new DateTime('@' . $day['dt'])
            ];
        }
        return $results;
    }

    /**
     * Executes API request and throws exceptions on failures
     */
    private function callAPI(string $endpoint): array
    {
        $url = "http://api.openweathermap.org/data/2.5/{$endpoint}&units=metric&lang=fr&APPID={$this->apiKey}&units=metric&units=metric&lang=fr";

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CAINFO         => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cert.pem',
            CURLOPT_TIMEOUT        => 3
        ]);

        $data = curl_exec($curl);

        // Handle cURL errors
        if ($data === false) {
            throw new CurlException($curl);
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Handle HTTP non-200 errors
        if ($code !== 200) {
            if ($code === 401) {
                $response = json_decode($data, true);
                throw new UnauthorizedHttpException($response['message'] ?? 'Clé API invalide', $code);
            }
            throw new HttpException($data, $code);
        }

        return json_decode($data, true);
    }
}