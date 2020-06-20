<?php

use \Carbon\Carbon;

class Metric extends Eloquent {
  use Validatable;
  use Queryable;

  const PAGEVIEWS = 'ga:pageviews';
  const UNIQUE_VISITORS = 'ga:visitors';

  protected $fillable = array('date', 'site_id', 'type', 'count');

  public static $rules = [
    'site_id' => 'required',
    'date' => 'required|date',
    'type' => 'required',
    'count' => 'required|integer'
  ];

  public function getDates() {
    return ['date'];
  }

  public static function uniqueVisitors() {
    return static::where('date', '<=', Carbon::today()->subDays(7))
       ->where('type', static::UNIQUE_VISITORS)
       ->orderBy('date')
       ->get();
  }

  public static function pageViews() {
    return static::where('date', '<=', Carbon::today()->subDays(7))
         ->where('type', static::PAGEVIEWS)
         ->orderBy('date')
         ->get();
  }
}

