<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Accounts as Accounts;

class UserController extends BaseController
{
    const DEFAULT_PASS = 'bvmsPass';

    public function index()
    {
    	if (session()->get('userSession') === null) {
    		return redirect()->route('login');
    	}
    	var_dump(session()->all());
    }

    public function loginView()
    {
        // var_dump(DB::table('accounts')->get());
        // var_dump(Accounts::all());
    	return view('pages.login');
    }

    public function login(Request $request)
    {
        $aRequest = $request->all();

        // validate request here
        $aLoginResult = DB::table('accounts')
            ->where('account_uname', $aRequest['username'])
            ->where('account_password', sha1($aRequest['password']))
            ->first();

        if ($aLoginResult === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Login failed. Wrong username/password.'
            ];
            return $this->returnJson($aReturn);
        }

        // Validate if suspended
        if ($aLoginResult->account_suspend === 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Your account is suspended. Please contact system administrator.'
            ];
            return $this->returnJson($aReturn);
        }

        $aUsers = DB::table('users')
            ->where('account_id', $aLoginResult->account_id)
            ->first();
            
        $aUserSession = array(
            'fname'        => $aUsers->user_fname,
            'lname'        => $aUsers->user_lname,
            'account_id'   => $aLoginResult->account_id,
            'account_type' => $aLoginResult->account_type,
            'user_photo'   => $aUsers->user_photo
        );
        session()->put('userSession', $aUserSession);
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function addUser()
    {
        return view('pages.userAdd');
    }

    public function checkUniqUser($sUsername)
    {
        $aUser = DB::table('users')
            ->where('account_id', $aLoginResult->account_id)
            ->first();

        return $aUser === null ? true : false;
    }

    public function addNewUser(Request $request)
    {
        $aNewAccount = $request->all();
        $bCheckUniqUser = $this->checkUniqUser($aNewAccount['userName']);
        if ($bCheckUniqUser === false) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Username exists. Please change username and try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aNewAccount = $this->uploadPhoto($aNewAccount, 'userPhoto', '/profile');

        // if ($request->has('userPhoto')) {
        //     // Get image file
        //     $image = $request->file('userPhoto');
        //     // Make a image name based on user name and current timestamp
        //     $name = str_slug($request->input('userName')).'_'.time();
        //     // Define folder path
        //     $folder = '/profile';
        //     // Make a file path where image will be stored [ folder path + file name + file extension]
        //     $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        //     // Upload image
        //     $file = $this->uploadOne($image, $folder, 'public', $name);
        //     var_dump($file);
        //     // Set user profile image path in database to filePath
        //     // $user->profile_image = $filePath;
        // }

        // var_dump($aNewAccount);

        $iAccountId = DB::table('accounts')->insertGetId([
            'account_uname'    => $aNewAccount['userName'],
            'account_password' => sha1(static::DEFAULT_PASS),
            'account_type'     => 1,
            'account_suspend'  => 0
        ]);
        if ($iAccountId === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Adding new user failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        return $this->addUserDetails($iAccountId, $aNewAccount);
    }

    public function addUserDetails($iAccountId, $aNewAccount)
    {
        $iUserId = DB::table('users')->insertGetId([
            'account_id'     => $iAccountId,
            'user_fname'     => $aNewAccount['nameFirst'] . ' ' . $aNewAccount['nameInit'],
            'user_lname'     => $aNewAccount['nameLast'],
            'user_photo'     => $aNewAccount['userPhoto'],
            'user_contactno' => $aNewAccount['contactNo']
        ]);
        if ($iAccountId === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Adding new user failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function suspendUserView()
    {
        $aAccounts = DB::table('accounts')->get();
        $aUsers = DB::table('users')->get();
        return view('pages.userList', [
            'aAccounts' => $aAccounts,
            'aUsers'    => $aUsers
        ]);
    }

    public function suspendUser(Request $request)
    {
        $aAccount = $request->all();
        $bResult = DB::table('accounts')
            ->where('account_id', $aAccount['iUserId'])
            ->update(['account_suspend' => $aAccount['iSuspend']]);

        if ($bResult !== 1) {
            $sMessage = $aAccount['iSuspend'] === 1 ? 'suspension' : 'activation';
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'User '. $sMessage .' failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function brgyInfo()
    {
        return view('pages.brgyinfo');
    }
}
