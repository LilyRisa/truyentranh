<?php

namespace App\Service;

use Exception;
use Google\Client;

class GoogleApi {

    public static $_instance = null;

    private $client = null;
    private $client2 = null;
    private $profileID = null;
    private $analytics = null;
    private $endpoint_index = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
    private $endpoint_check = 'https://indexing.googleapis.com/v3/urlNotifications/metadata?url=';

    private $type_keys = [
        "update" => "URL_UPDATED",
        "delete" => "URL_DELETED"
    ];

    private $_scope = [
        'index' => 'https://www.googleapis.com/auth/indexing',
        'search_analytic' => 'https://www.googleapis.com/auth/webmasters',
        'analytics' => 'https://www.googleapis.com/auth/analytics.readonly'
    ];
    

    private function __construct(){
        $this->client = new Client();
        $this->client2 = new Client();
        $this->client->setAuthConfig(base_path().'/groovy-medium-325709-557003476d90.json');
        $this->client2->setAuthConfig(base_path().'/groovy-medium-325709-557003476d90.json');
        
    }
    public function addScope($scope = 'index'){
        if(empty($this->_scope[$scope])) throw new \Exception('Khong co scope hop le');
        $this->client->addScope($this->_scope[$scope]);
        $this->client2->addScope($this->_scope[$scope]);
        return $this;
    }
    private function add_site($site = 'https://forextradingvn.top/'){
        $response = $this->client->put('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($site));
        return $response;
    }

    public function initializeAnalytics(){
        $this->client2->setApplicationName("forextradingvn.top");
        $this->analytics = new \Google_Service_Analytics($this->client2);
        return $this;
    }

    public function getRealtimeUser(){
        $option =  json_encode([
            'dimensions' => [['name' => 'country']],
            'metrics' => [['name' => 'activeUsers']],
        ]);
        $this->client2 = $this->client2->authorize();
        $data = $this->client2->post('https://analyticsdata.googleapis.com/v1beta/properties/333983151:runRealtimeReport', ['body' => $option]);
        $body = $data->getBody()->getContents();
        
        return json_decode($body);
    }

    public function getFirstProfileId() {
        // Get the user's first view (profile) ID.
        $analytics = $this->analytics;
        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();
      
        if (count($accounts->getItems()) > 0) {
          $items = $accounts->getItems();
          $firstAccountId = $items[0]->getId();
      
          // Get the list of properties for the authorized user.
          $properties = $analytics->management_webproperties
              ->listManagementWebproperties($firstAccountId);
      
          if (count($properties->getItems()) > 0) {
            $items = $properties->getItems();
            $firstPropertyId = $items[0]->getId();
      
            // Get the list of views (profiles) for the authorized user.
            $profiles = $analytics->management_profiles
                ->listManagementProfiles($firstAccountId, $firstPropertyId);
      
            if (count($profiles->getItems()) > 0) {
              $items = $profiles->getItems();
      
              // Return the first view (profile) ID.
              $this->profileID = $items[0]->getId();
              return $this;
      
            } else {
              throw new Exception('No views (profiles) found for this user.');
            }
          } else {
            throw new Exception('No properties found for this user.');
          }
        } else {
          throw new Exception('No accounts found for this user.');
        }
      }
      
    public function getResults() {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        $analytics = $this->analytics;
        $profileId = $this->profileID;

         return $analytics->data_ga->get(
             'ga:' . $profileId,
             '7daysAgo',
             'today',
             'ga:sessions');
      }

    public function getSearch($StartDate, $EndDate, $site = 'https://forextradingvn.top/'){
        $data = [
            'startDate' => date('Y-m-d', strtotime($StartDate)),
            'endDate' => date('Y-m-d', strtotime($EndDate)),
            // 'dimensions' => ['DATE']
        ];
        try{
            $response = $this->client->post('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($site).'/searchAnalytics/query', ['form_params' => $data]);
            $status = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            if($status !== 200) return false;
            return $body;
        }
        catch(\Exception $e ) {
            return ['status'=> false, 'notify' => $e->getMessage()];
        } 
    }

    public function getSearch2($StartDate, $EndDate, $site = 'https://forextradingvn.top/do-kwon-bi-interpol-truy-na-do-tren-toan-cau-p91.html'){
        $this->add_site($site);
        $q = new \Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $q->setStartDate(date('Y-m-d', strtotime($StartDate)));
        $q->setEndDate(date('Y-m-d', strtotime($EndDate)));
        $q->setDimensions(['SEARCH_APPEARANCE']);
        try{
            $service = new \Google_Service_Webmasters($this->client2);
            $u = $service->searchanalytics->query($site, $q);
            return $u;
        }
        catch(\Exception $e ) {
            return ['status'=> false, 'notify' => $e->getMessage()];
        } 
    }

    public static function init(){
        if(empty(self::$_instance)){
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function index(...$param){
        $this->client = $this->client->authorize();
        if(count($param) == 2){
            $action = $param[1];
            $url = $param[0];
        }else if(count($param) == 1){
            $action = 'update';
            $url = $param[0];
        }else{
            throw new \Exception('Tham so truyen vao khong hop le');
        }
        
        $data = json_encode([
            'url' => $url,
            'type' => $this->type_keys[$action],
        ]);
        $response = $this->client->post($this->endpoint_index, ['body' => $data]);
        $status = $response->getStatusCode();
        $body = json_decode($response->getBody());
        if($status !== 200) return false;
        return $body;
    }

    public function check(...$param){
        $this->client = $this->client->authorize();
        if(empty($param)) throw new \Exception('Khong co tham so truyen vao');
        $url = urlencode($param[0]);

        // dd($this->endpoint_check.$url);
        $response = $this->client->get($this->endpoint_check.$url);
        $status = $response->getStatusCode();
        $body = json_decode($response->getBody());

        if($status !== 200) return false;
        return $body;
    }

}