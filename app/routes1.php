<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


    /* Reports */
    Route::get('reports', array('as' => 'reports', 'uses' => 'trxReportsController@index'));

    Route::get('reports/{dtrs}', array('as' => 'reports/{dtrs}', 'uses' => 'trxReportsController@Reports'));

    Route::get('showrpt', array('as' => 'showrpt', 'uses' => 'ShowReportController@index'));
    
    Route::post('exporttrx', array('as' => 'exporttrx', 'uses' => 'ShowReportController@exportTrxLogs'));
    
	
	