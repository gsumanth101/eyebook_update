<?php

include('../../config/connection.php');
require '../../vendor/autoload.php'; // Include Composer's autoloader

use GuzzleHttp\Client;

class ZoomAPI {
    private $clientId;
    private $clientSecret;
    private $accountId;
    private $accessToken;
    private $client;
    private $conn;

    public function __construct($clientId, $clientSecret, $accountId, $conn) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accountId = $accountId;
        $this->client = new Client(['base_uri' => 'https://zoom.us/']);
        $this->conn = $conn;
        $this->accessToken = $this->generateAccessToken();
    }

    private function generateAccessToken() {
        $response = $this->client->request('POST', 'oauth/token', [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => [
                'grant_type' => 'account_credentials',
                'account_id' => $this->accountId
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }

    public function createMeeting($topic, $startTime, $duration, $createdBy) {
        $response = $this->client->request('POST', 'v2/users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'topic' => $topic,
                'type' => 2, // Scheduled meeting
                'start_time' => $startTime,
                'duration' => $duration,
                'timezone' => 'UTC'
            ]
        ]);

        $meetingData = json_decode($response->getBody(), true);
        $this->saveMeetingToDatabase($meetingData, $createdBy);
        return $meetingData;
    }

    private function saveMeetingToDatabase($meetingData, $createdBy) {
        $stmt = $this->conn->prepare("INSERT INTO meetings (meeting_id, topic, start_time, duration, join_url, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", 
            $meetingData['id'],
            $meetingData['topic'],
            $meetingData['start_time'],
            $meetingData['duration'],
            $meetingData['join_url'],
            $createdBy
        );
        $stmt->execute();
        $stmt->close();
    }

    public function getMeetingsByFaculty($facultyId) {
        $stmt = $this->conn->prepare("SELECT * FROM meetings WHERE created_by = ?");
        $stmt->bind_param("s", $facultyId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $meetings = [];
        while ($row = $result->fetch_assoc()) {
            $meetings[] = $row;
        }
        
        $stmt->close();
        return $meetings;
    }

    public function getAllMeetings() {
        $result = $this->conn->query("SELECT * FROM meetings");
        $meetings = [];
        while ($row = $result->fetch_assoc()) {
            $meetings[] = $row;
        }
        return $meetings;
    }
}

// Load configuration
$config = require 'config.php';

// Instantiate ZoomAPI with your credentials
$zoom = new ZoomAPI($config['zoom']['client_id'], $config['zoom']['client_secret'], $config['zoom']['account_id'], $conn);
?>