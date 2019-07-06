<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware'=>'auth','prefix' => '/'], function(){
    Route::get('/', 'DashboardController@index');
//My Account
    Route::group(array('prefix'=> 'myprofile'), function(){
        Route::get('/', 'MyAccountController@index');
        Route::post('update', 'MyAccountController@edit');
        Route::post('upload', 'MyAccountController@uploadPic');
    });
    
//User Routes
    Route::group(array('prefix'=> 'users'), function(){
        //USERS
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'UserController@index');
            Route::get('view/{id}', 'UserController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'UserController@add');
            Route::match(array('GET','POST'),'update/{id}', 'UserController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'UserController@delete')->where('id', '[0-9]+');
        });
        //GROUP
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'GroupController@index');
            Route::get('view/{id}', 'GroupController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'GroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'GroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'GroupController@delete')->where('id', '[0-9]+');
        });
    });

//Stations
    Route::group(array('prefix'=> 'stations'), function(){
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'Station\StationsController@index');
            Route::get('view/{id}', 'Station\StationsController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Station\StationsController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Station\StationsController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Station\StationsController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Station\StationsController@data');
        });
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'Station\StationGroupController@index');
            Route::get('view/{id}', 'Station\StationGroupController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Station\StationGroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Station\StationGroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Station\StationGroupController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Station\StationGroupController@data');
        });
        Route::group(array('prefix'=> 'access'), function(){
            Route::get('/', 'Station\StationAccessController@index');
            Route::get('view/{id}', 'Station\StationAccessController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Station\StationAccessController@add');
            // Route::match(array('GET','POST'),'update/{id}', 'Station\StationAccessController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Station\StationAccessController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Station\StationAccessController@data');
        });
    });

//Classification
    Route::group(array('prefix'=> 'classification'), function(){
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'Classification\ClassificationController@index');
            Route::get('view/{id}', 'Classification\ClassificationController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Classification\ClassificationController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Classification\ClassificationController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Classification\ClassificationController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Classification\ClassificationController@data');
        });
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'Classification\ClassificationGroupController@index');
            Route::get('view/{id}', 'Classification\ClassificationGroupController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Classification\ClassificationGroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Classification\ClassificationGroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Classification\ClassificationGroupController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Classification\ClassificationGroupController@data');
        });
    });

//Member
    Route::group(array('prefix'=> 'member'), function(){
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'Member\MemberController@index');
            Route::get('view/{id}', 'Member\MemberController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Member\MemberController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Member\MemberController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Member\MemberController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Member\MemberController@data');
        });
    });

//Guest
    Route::group(array('prefix'=> 'guest'), function(){
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'Guest\GuestTagController@index');
            Route::get('view/{id}', 'Guest\GuestTagController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Guest\GuestTagController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Guest\GuestTagController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Guest\GuestTagController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Guest\GuestTagController@data');
        });
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'Guest\GuestGroupController@index');
            Route::get('view/{id}', 'Guest\GuestGroupController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Guest\GuestGroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Guest\GuestGroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Guest\GuestGroupController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Guest\GuestGroupController@data');
        });
        Route::group(array('prefix'=> 'access'), function(){
            Route::get('/', 'Guest\GuestAccessController@index');
            Route::get('view/{id}', 'Guest\GuestAccessController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Guest\GuestAccessController@add');
            // Route::match(array('GET','POST'),'update/{id}', 'Guest\GuestAccessController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Guest\GuestAccessController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Guest\GuestAccessController@data');
        });
        Route::group(array('prefix'=> 'add_guest'), function(){
            Route::get('/', 'Guest\GuestAddController@index');
            Route::get('view/{id}', 'Guest\GuestAddController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Guest\GuestAddController@add');
            // Route::match(array('GET','POST'),'update/{id}', 'Guest\GuestAddController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Guest\GuestAddController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Guest\GuestAddController@data');
        });
    });

//Attendance
    Route::group(array('prefix'=> 'attendance'), function(){
        Route::group(array('prefix'=> 'station'), function(){
            Route::get('/', 'Attendance\AttendanceStationController@index');
            Route::get('view/{id}', 'Attendance\AttendanceStationController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Attendance\AttendanceStationController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Attendance\AttendanceStationController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Attendance\AttendanceStationController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Attendance\AttendanceStationController@data');
        });
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'Attendance\AttendanceGroupController@index');
            Route::get('view/{id}', 'Attendance\AttendanceGroupController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Attendance\AttendanceGroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'Attendance\AttendanceGroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Attendance\AttendanceGroupController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Attendance\AttendanceGroupController@data');
        });
        Route::group(array('prefix'=> 'access'), function(){
            Route::get('/', 'Attendance\AttendanceAccessController@index');
            Route::get('view/{id}', 'Attendance\AttendanceAccessController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'add', 'Attendance\AttendanceAccessController@add');
            // Route::match(array('GET','POST'),'update/{id}', 'Attendance\AttendanceAccessController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'Attendance\AttendanceAccessController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Attendance\AttendanceAccessController@data');
        });
    });

// Monitor
    Route::group(array('prefix'=> 'monitor'), function(){
        Route::group(array('prefix'=> 'controller'), function(){
            Route::get('/', 'Monitor\StationController@index');
            Route::get('view/{id}', 'Monitor\StationController@view')->where('id', '[0-9]+');
            Route::match(array('GET','POST'),'update/{id}', 'Monitor\StationController@edit')->where('id', '[0-9]+');
            Route::get('data', 'Monitor\StationController@data');
        });
        Route::group(array('prefix'=> 'station'), function(){
            Route::get('/', 'Monitor\MonitorStationController@index');
            Route::get('view/{id}', 'Monitor\MonitorStationController@view');
            Route::get('data', 'Monitor\MonitorStationController@data');
        });
        Route::group(array('prefix'=> 'history'), function(){
            Route::get('/', 'Monitor\MonitorHistoryController@index');
            Route::get('view/{id}', 'Monitor\MonitorHistoryController@view');
            Route::get('data', 'Monitor\MonitorHistoryController@data');
        });
        Route::group(array('prefix'=> 'attendance'), function(){
            Route::get('/', 'Monitor\MonitorAttendanceController@index');
            Route::get('view/{id}', 'Monitor\MonitorAttendanceController@view');
            Route::get('data', 'Monitor\MonitorAttendanceController@data');
        });
        Route::group(array('prefix'=> 'network'), function(){
            Route::get('/', 'Monitor\NetworkController@index');
            Route::get('data', 'Monitor\NetworkController@data');
        });
    });

//Uploading
    Route::group(array('prefix'=> 'upload'), function(){
        Route::group(array('prefix'=> 'member'), function(){
            Route::get('/', 'Upload\UploadMemberController@index');
            Route::get('view/{id}', 'Upload\UploadMemberController@view');
            Route::match(array('POST'),'add', 'Upload\UploadMemberController@add');
            Route::match(array('POST'),'sync', 'Upload\UploadMemberController@sync');
            Route::match(array('POST'),'transfer', 'Upload\UploadMemberController@transfer');
            Route::get('data', 'Upload\UploadMemberController@data');
        });
        Route::group(array('prefix'=> 'sync'), function(){
            Route::get('/', 'Upload\UploadSyncController@index');
        });
    });

//SMS
    Route::group(array('prefix'=> 'sms'), function(){
        //SMS SERVER
        Route::group(array('prefix'=> 'server'), function(){
            Route::get('/', 'SMS\ServerController@index');
            Route::get('view/{id}', 'SMS\ServerController@view');
            Route::match(array('GET','POST'),'add', 'SMS\ServerController@add');
            Route::match(array('GET','POST'),'update/{id}', 'SMS\ServerController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'SMS\ServerController@delete')->where('id', '[0-9]+');
            Route::get('data', 'SMS\ServerController@data');
        });
        //SMS GROUP
        Route::group(array('prefix'=> 'group'), function(){
            Route::get('/', 'SMS\GroupController@index');
            Route::get('view/{id}', 'SMS\GroupController@view');
            Route::match(array('GET','POST'),'add', 'SMS\GroupController@add');
            Route::match(array('GET','POST'),'update/{id}', 'SMS\GroupController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'SMS\GroupController@delete')->where('id', '[0-9]+');
            Route::get('data', 'SMS\GroupController@data');
        });
        //SMS Prefix
        Route::group(array('prefix'=> 'prefix'), function(){
            Route::get('/', 'SMS\PrefixController@index');
            Route::get('view/{id}', 'SMS\PrefixController@view');
            Route::match(array('GET','POST'),'add', 'SMS\PrefixController@add');
            Route::match(array('GET','POST'),'update/{id}', 'SMS\PrefixController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'SMS\PrefixController@delete')->where('id', '[0-9]+');
            Route::get('data', 'SMS\PrefixController@data');
        });
        //SMS Access
        Route::group(array('prefix'=> 'access'), function(){
            Route::get('/', 'SMS\AccessController@index');
            Route::get('view/{id}', 'SMS\AccessController@view');
            Route::match(array('POST'),'add', 'SMS\AccessController@add');
            // Route::match(array('GET','POST'),'update/{id}', 'SMS\AccessController@edit')->where('id', '[0-9]+');
            Route::post('delete/{id}', 'SMS\AccessController@delete')->where('id', '[0-9]+');
            Route::get('data', 'SMS\AccessController@data');
        });
    });

//Blast
    Route::group(array('prefix'=> 'blast'), function(){
        Route::group(array('prefix'=> '/'), function(){
            Route::get('/', 'Messaging\DirectMessageController@index');
            Route::get('view/{id}', 'Messaging\DirectMessageController@view');
            Route::match(array('POST'),'add', 'Messaging\DirectMessageController@add');
        });
        Route::group(array('prefix'=> 'occurance'), function(){
            Route::get('/', 'Messaging\ScheduledMessageController@index');
            Route::get('view/{id}', 'Messaging\ScheduledMessageController@view');
            Route::match(array('GET','POST'),'add', 'Messaging\ScheduledMessageController@add');
            Route::post('delete/{id}', 'Messaging\ScheduledMessageController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Messaging\ScheduledMessageController@data');
        });
        Route::group(array('prefix'=> 'late_absent'), function(){
            Route::get('/', 'Messaging\LateAbsentController@index');
            Route::get('view/{id}', 'Messaging\LateAbsentController@view');
            Route::match(array('GET','POST'),'add', 'Messaging\LateAbsentController@add');
            Route::post('delete/{id}', 'Messaging\LateAbsentController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Messaging\LateAbsentController@data');
        });
        Route::group(array('prefix'=> 'excemption'), function(){
            Route::get('/', 'Messaging\DateExcemptionController@index');
            Route::get('view/{id}', 'Messaging\DateExcemptionController@view');
            Route::match(array('GET','POST'),'add', 'Messaging\DateExcemptionController@add');
            Route::post('delete/{id}', 'Messaging\DateExcemptionController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Messaging\DateExcemptionController@data');
        });
        Route::group(array('prefix'=> 'holiday'), function(){
            Route::get('/', 'Messaging\HolidayController@index');
            Route::get('view/{id}', 'Messaging\HolidayController@view');
            Route::match(array('GET','POST'),'add', 'Messaging\HolidayController@add');
            Route::post('delete/{id}', 'Messaging\HolidayController@delete')->where('id', '[0-9]+');
            Route::get('data', 'Messaging\HolidayController@data');
        });
    });
});

Route::match(array('get', 'post'),'login',function(){
    if (Request::isMethod('post') && Input::has('username') && Input::has('password')){
        $username = Input::get('username');
        $password = Input::get('password');
        if (Auth::attempt(array('username' => $username, 'password' => $password, 'status' => 'Active', 'remove_status' => 'Inactive'))){
            return Redirect::to('/');
        }
    }
    return view('login');
});

Route::get('logout',function(){
    $user = App\Models\ACL\User::find(Auth::id());
    $user->last_login = Carbon\Carbon::now();
    $user->save();
    Auth::logout();
    return Redirect::to('/');
});

Route::get('API','API\APIController@index');