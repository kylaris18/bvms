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
    }

    public function loginView()
    {
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
            'fname'          => $aUsers->user_fname,
            'lname'          => $aUsers->user_lname,
            'account_id'     => $aLoginResult->account_id,
            'account_type'   => $aLoginResult->account_type,
            'user_contactno' => $aUsers->user_contactno,
            'account_uname'  => $aLoginResult->account_uname,
            'user_photo'     => $aUsers->user_photo
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
        $aUser = DB::table('accounts')
            ->where('account_uname', $sUsername)
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
            'user_fname'     => $aNewAccount['nameFirst'],
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
        $aBrgy = DB::table('brgies')
            ->first();
        $aCouncilors = DB::table('councilors')
            ->get();
        $iTanod = DB::table('users')
            ->count();
        return view('pages.brgyinfo', [
            'aBrgy'       => $aBrgy,
            'aCouncilors' => $aCouncilors,
            'iTanod'      => $iTanod - 1
        ]);
    }

    public function modifyBrgyInfo(Request $request)
    {
        $aBrgy = $request->all();
        $bBrgyResult = DB::table('brgies')
            ->where('id', 1)
            ->update([
                'brgy_name'    => $aBrgy['brgyName'],
                'brgy_address' => $aBrgy['brgyAddress'],
                'brgy_captain' => $aBrgy['brgyCaptain'],
                'brgy_sk'      => $aBrgy['brgySk']
            ]);
        if ($bBrgyResult !== 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Modify Brgy Failed. Please change some details and try Again.'
            ];
            return $this->returnJson($aReturn);
        }

        DB::table('councilors')->truncate();

        $aCouncilors = [];

        foreach ($aBrgy['brgyCouncilor'] as $sCouncilor) {
            $aCouncilors[] = ['councilor_name' => $sCouncilor];
        }

        $bCouncilorResult = DB::table('councilors')->insert($aCouncilors);
        if ($bCouncilorResult !== true) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Modify Councilors Failed. Please Try Again.'
            ];
            return $this->returnJson($aReturn);
        }

        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function updateUser()
    {
        return view('pages.userUpdate');
    }

    public function modifyUser(Request $request)
    {
        $aAccount = $request->all();
        if ($aAccount['userName'] !== session()->get('userSession')['account_uname']) {
            $bCheckUniqUser = $this->checkUniqUser($aAccount['userName']);
            if ($bCheckUniqUser === false) {
                $aReturn = [
                    'bResult'  => false,
                    'sMessage' => 'Username exists. Please change username and try again.'
                ];
                return $this->returnJson($aReturn);
            }
        }
        $aAccount = $this->uploadPhoto($aAccount, 'userPhoto', '/profile');
        $aUpdate = ['account_uname' => $aAccount['userName']];
        $aUpdate = $this->validateChangePass($aUpdate, $aAccount);
        if (array_key_exists('bResult', $aUpdate) === true) {
            return $this->returnJson($aUpdate);
        }
        $bResult = DB::table('accounts')
            ->where('account_id', $aAccount['account_id'])
            ->update($aUpdate);
        return $this->updateUserDetails($aAccount['account_id'], $aAccount, $bResult);
    }

    public function updateUserDetails($iAccountId, $aAccount, $bAccountUpdate)
    {
        $aUpdate = [
            'user_fname' => $aAccount['nameFirst'],
            'user_lname' => $aAccount['nameLast'],
            'user_contactno' => $aAccount['contactNo']
        ];
        if (array_key_exists('userPhoto', $aAccount) === true) {
            $aUpdate['user_photo'] = $aAccount['userPhoto'];
        }
        $bResult = DB::table('users')
            ->where('account_id', $aAccount['account_id'])
            ->update($aUpdate);
        if ($bResult !== 1 && $bAccountUpdate !== 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Update Account and Profile Failed. Please change some details and try Again.'
            ];
            return $this->returnJson($aReturn);
        }

        $aUserSession = array(
            'fname'          => $aAccount['nameFirst'],
            'lname'          => $aAccount['nameLast'],
            'account_id'     => session()->get('userSession')['account_id'],
            'account_type'   => session()->get('userSession')['account_type'],
            'user_contactno' => array_key_exists('contactno', $aAccount) === true ? $aAccount['contactno'] : session()->get('userSession')['user_contactno'],
            'user_photo'     => session()->get('userSession')['user_photo'],
            'account_uname'  => $aAccount['userName']
        );
        session()->put('userSession', $aUserSession);
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function validateChangePass($aUpdate, $aAccount)
    {
        if ($aAccount['currPass'] === null || $aAccount['newPass'] === null || $aAccount['repeatPass'] === null) {
            return $aUpdate;
        }
        $aLoginResult = DB::table('accounts')
            ->where('account_uname', $aAccount['userName'])
            ->where('account_password', sha1($aAccount['currPass']))
            ->first();

        if ($aLoginResult === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Wrong password. Please try Again.'
            ];
            return $aReturn;
        }

        if ($aAccount['newPass'] !== $aAccount['repeatPass']) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Password does not match. Please try Again.'
            ];
        }

        $aUpdate['account_password'] = sha1($aAccount['newPass']);
        return $aUpdate;
    }
}
