<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;


class GoogleCalendarController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Calendar');
        $this->client->setScopes(Calendar::CALENDAR_READONLY);
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    // Step 1: Redirect to Google's OAuth 2.0 Server
    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect($authUrl);
    }

   
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->get('code');

        if ($code) {
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
            $this->client->setAccessToken($accessToken);

           
            session(['google_access_token' => $accessToken]);

            return redirect()->route('google.calendar.events');
        }

        return redirect()->route('google.redirect')->with('error', 'Authorization failed');
    }

   
    public function listGoogleCalendarEvents()
    {
        if (!session()->has('google_access_token')) {
            return redirect()->route('google.redirect')->with('error', 'Please authenticate first');
        }

        $accessToken = session('google_access_token');
        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            return redirect()->route('google.redirect')->with('error', 'Access token expired. Please reauthenticate.');
        }

        $service = new Calendar($this->client);
        $events = $service->events->listEvents('primary', [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
        ]);

        return view('google.calendar.events', ['events' => $events->getItems()]);
    }
}
