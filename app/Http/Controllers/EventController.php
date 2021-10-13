<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return view('events.create-event');
    }

    public function createEvent(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $youtube_url = $request->get('youtube_url');
        $guid = $request->get('guid');

        $data = [
            "guid" => $guid,
            "name" => $title,
            "type" => 'public'
        ];

        try {
            Http::withHeaders([
                'appId' =>  env('MIX_COMMETCHAT_APP_ID'),
                'apiKey' => env('MIX_COMMETCHAT_REST_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withBody(json_encode($data), 'application/json')
                ->post('https://api-us.cometchat.io/v2.0/groups');


            Event::create([
                "title" => $title,
                "description" => $description,
                "youtube_url" => $youtube_url,
                "cometchat_group_id" => $guid
            ]);

            return response()->json([
                "success" => true,
                "message" => "Event created successfully"
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "An error occur"
            ]);
        }
    }

    public function viewEvent($id)
    {
        $event = Event::where('cometchat_group_id', $id)->first();
        return response()->json([
            "event" => $event,
            "user" => Auth::user(),
            "success" => true,
            "message" => "Event retrieved successfully"
        ]);
    }

    public function viewEvents()
    {
        $events = Event::orderBy('created_at', 'DESC')->get();
        return response()->json([
            "events" => $events,
            "user" => Auth::user(),
            "success" => true,
        ]);
    }

    public function viewSingleEvent($id)
    {
        return view('events.event', compact(['id']));
    }
}
