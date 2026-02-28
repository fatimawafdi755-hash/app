<?php
class CountryDetector {
    private $sessionKey = 'country_detection_results';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function detectCountry() {
        $methods = [
            'cloudflare' => 'getCountryFromCloudflare',
            'cdn' => 'getCountryFromCDN',
            'api' => 'getCountryFromAPIs',
            'browser' => 'getCountryFromBrowser',
            'server' => 'getCountryFromServer'
        ];

        $results = [];

        foreach ($methods as $methodName => $method) {
            $result = $this->$method();
            $results[$methodName] = [
                'code' => $result,
                'timestamp' => time()
            ];

            $_SESSION[$this->sessionKey][$methodName] = $results[$methodName];

            if ($result) {
                return [
                    'code' => $result,
                    'method' => $methodName,
                    'all_methods' => $results
                ];
            }
        }

        return [
            'code' => null,
            'method' => 'not_detected',
            'all_methods' => $results,
            'error' => 'Could not detect country using any method'
        ];
    }

    // Call specific method by name
    public function callMethod($methodName) {
        $methods = [
            'cloudflare' => 'getCountryFromCloudflare',
            'cdn' => 'getCountryFromCDN',
            'api' => 'getCountryFromAPIs',
            'browser' => 'getCountryFromBrowser',
            'server' => 'getCountryFromServer'
        ];

        if (isset($methods[$methodName])) {
            $method = $methods[$methodName];
            $result = $this->$method();

            $_SESSION[$this->sessionKey][$methodName] = [
                'code' => $result,
                'timestamp' => time()
            ];

            return $result;
        }

        return null;
    }

    // Enable calling detection methods like $detector->cloudflare()
    public function __call($name, $arguments) {
        return $this->callMethod($name);
    }

    // Call multiple specific methods
    public function callMethods($methodNames) {
        $results = [];

        foreach ($methodNames as $methodName) {
            $results[$methodName] = $this->callMethod($methodName);
        }

        return $results;
    }

    // Get all available methods
    public function getAllMethods() {
        return [
            'cloudflare' => 'Cloudflare Headers',
            'cdn' => 'CDN Headers',
            'api' => 'API Geolocation',
            'browser' => 'Browser Language',
            'server' => 'Server Location'
        ];
    }

    private function getCountryFromCloudflare() {
        $headers = [
            'HTTP_CF_IPCOUNTRY',
            'HTTP_CF_IPCOUNTRY_CODE',
            'HTTP_CLOUDFLARE_IPCOUNTRY'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $country = strtoupper(trim($_SERVER[$header]));
                if (preg_match('/^[A-Z]{2,3}$/', $country)) {
                    return $country;
                }
            }
        }
        return null;
    }

    private function getCountryFromCDN() {
        $headers = [
            'HTTP_X_COUNTRY_CODE',
            'HTTP_X_GEOIP_COUNTRY',
            'HTTP_X_IPSTACK_COUNTRY_CODE',
            'HTTP_X_IPINFO_COUNTRY',
            'HTTP_GEOIP_COUNTRY_CODE',
            'HTTP_X_APPENGINE_COUNTRY'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $country = strtoupper(trim($_SERVER[$header]));
                if (preg_match('/^[A-Z]{2,3}$/', $country)) {
                    return $country;
                }
            }
        }
        return null;
    }

    private function getCountryFromAPIs() {
        $ip = $this->getRealIP();
        if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
            return null;
        }

        $apis = [
            [
                'url' => "https://ipapi.co/{$ip}/json/",
                'field' => 'country_code'
            ],
            [
                'url' => "https://ipinfo.io/{$ip}/json",
                'field' => 'country'
            ],
            [
                'url' => "http://www.geoplugin.net/json.gp?ip={$ip}",
                'field' => 'geoplugin_countryCode'
            ],
            [
                'url' => "https://api.ipbase.com/v1/json/{$ip}",
                'field' => 'country_code'
            ],
            [
                'url' => "https://api.country.is/{$ip}",
                'field' => 'country'
            ],
            [
                'url' => "https://freeipapi.com/api/json/{$ip}",
                'field' => 'countryCode'
            ]
        ];

        shuffle($apis);

        foreach ($apis as $api) {
            try {
                $country = $this->callAPI($api['url'], $api['field']);
                if ($country) {
                    return $country;
                }
            } catch (Exception $e) {
                continue;
            }

            usleep(50000);
        }

        return null;
    }

    private function getCountryFromBrowser() {
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $primaryLang = explode(';', $languages[0])[0];

            if (strpos($primaryLang, '-') !== false) {
                $country = explode('-', $primaryLang)[1];
                if (preg_match('/^[A-Z]{2,3}$/', $country)) {
                    return strtoupper($country);
                }
            }
        }
        return null;
    }

    private function getCountryFromServer() {
        $timezone = @date_default_timezone_get();
        if (strpos($timezone, '/') !== false) {
            $parts = explode('/', $timezone);
            $country = $parts[0];
            if (preg_match('/^[A-Z]{2,3}$/', $country)) {
                return strtoupper($country);
            }
        }
        return null;
    }

    private function callAPI($url, $field) {
        if (function_exists('curl_version')) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Country Detector)'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                return $this->extractCountryCode($data, $field);
            }
        } else {
            $context = stream_context_create([
                'http' => ['timeout' => 3, 'user_agent' => 'Mozilla/5.0 (Country Detector)'],
                'ssl' => ['verify_peer' => false]
            ]);

            $response = @file_get_contents($url, false, $context);
            if ($response) {
                $data = json_decode($response, true);
                return $this->extractCountryCode($data, $field);
            }
        }

        return null;
    }

    private function extractCountryCode($data, $field) {
        if (!$data) return null;

        $keys = explode('.', $field);
        $value = $data;

        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return null;
            }
            $value = $value[$key];
        }

        if (is_string($value) && preg_match('/^[A-Z]{2,3}$/', $value)) {
            return strtoupper($value);
        }

        return null;
    }

    private function getRealIP() {
        $headers = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function getSessionResults() {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function clearSessionResults() {
        unset($_SESSION[$this->sessionKey]);
    }

    public function getLastDetection() {
        $results = $this->getSessionResults();
        if (empty($results)) {
            return null;
        }

        foreach ($results as $method => $data) {
            if (!empty($data['code'])) {
                return [
                    'code' => $data['code'],
                    'method' => $method,
                    'timestamp' => $data['timestamp']
                ];
            }
        }

        return null;
    }

    public function getMethodResult($methodName) {
        $results = $this->getSessionResults();
        return $results[$methodName] ?? null;
    }

    public function getCountryCode() {
        $lastDetection = $this->getLastDetection();
        if ($lastDetection) {
            return $lastDetection['code'];
        }

        $result = $this->detectCountry();
        return $result['code'];
    }
}

$detector = new CountryDetector();
$detector->api();