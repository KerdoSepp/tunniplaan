<?php

use Carbon\Carbon;
use App\Models\Author;
use Illuminate\Support\Facades\Route;
use App\Mail\Timetable;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tere', function () {

    $authors = Author::all();

    $authors->load('books.reviews', 'reviews');

    // $books = [];

    // foreach ($authors as $author) {
    //     $books = array_merge($books, $author->books->toArray());
    // }
    
    return view('tere', [
        'authors' => $authors,
    ]);

});

Route::get('/mailable', function () {

    $startDate = Carbon::now()->startOfWeek();
    $endDate = Carbon::now()->endOfWeek();
    
     $response = Http::get('https://tahveltp.edu.ee/hois_back/timetableevents/timetableSearch', [
    'from' => $startDate,
    'lang' => "ET",
    'page' => 0,
    'schoolId' => 38,
    'size' => 50,
    'studentGroups' => "ea0550fb-8387-4aa2-880a-9abbd37a69ce",
    'thru' => $endDate,
    ])->json();

    $timetableEvents = collect($response['content'])
        ->sortBy(['date', 'timeStart'])
        ->groupBy(function ($event) {
            return Carbon::parse($event['date'])->locale('et_EE')->dayName;
        });


  return new Timetable($timetableEvents, $startDate, $endDate);
  });
