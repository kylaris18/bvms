<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends BaseController
{
    public function index()
    {
        $aViolators = DB::table('violators')->get();
        $aViolations = DB::table('violations')->latest()->get();
        $aUsers = DB::table('users')->get();
        $aTypes = DB::table('types')->get();
        return view('pages.violationList', [
            'aViolators'  => $aViolators,
            'aViolations' => $aViolations,
            'aUsers'      => $aUsers,
            'aTypes'      => $aTypes
        ]);
    }

    public function add()
    {
        $aTypes = DB::table('types')->get();
        $aViolators = DB::table('violators')->get();
    	return view('pages.violationAdd', [
            'aTypes' => $aTypes,
            'aViolators' => $aViolators
        ]);
    }

    public function addViolation(Request $request)
    {
        $aViolation = $request->all();
        $aViolation = $this->checkMiddleName($aViolation);
        $aViolator = DB::table('violators')
            ->where('violator_lname', $aViolation['nameLast'])
            ->where('violator_fname', $aViolation['nameFirst'])
            ->where('violator_mname', $aViolation['nameInit'])
            ->first();
        if ($aViolator === null) {
            $iViolatorId = DB::table('violators')->insertGetId([
                'violator_lname' => $aViolation['nameLast'],
                'violator_fname' => $aViolation['nameFirst'],
                'violator_mname' => $aViolation['nameInit'],
                'violator_count' => 0
            ]);
            return $this->checkViolation($iViolatorId, $aViolation);
        }
        return $this->checkViolation($aViolator->violator_id, $aViolation);
        
    }

    public function checkViolationType($aViolation)
    {
        if ($aViolation['violationList'] !== "0") {
            return $aViolation['violationList'];
        }
        return DB::table('types')->insertGetId([
            'type_name' => $aViolation['violationOthersField']
        ]);
    }

    public function recordViolation($iViolatorId, $aNewViolation)
    {
        $bImage = array_key_exists('violationProof', $aNewViolation);
        if ($bImage === true) {
            $aNewViolation = $this->uploadPhoto($aNewViolation, 'violationProof', '/uploads');
        }
        $iViolationType = $this->checkViolationType($aNewViolation);
        if ($iViolationType === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Violation recording failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $iViolationId = DB::table('violations')->insertGetId([
            'type_id'            => $iViolationType,
            'account_id'         => session()->get('userSession')['account_id'],
            'violation_violator' => $iViolatorId,
            'violation_date'     => strtotime($aNewViolation['violationDate']),
            'violation_report'   => time(),
            'violation_status'   => $aNewViolation['status'],
            'violation_notes'    => $aNewViolation['violationNotes'],
            'violation_photo'    => $bImage === true ? $aNewViolation['violationProof'] : 'N/A'
        ]);
        if ($iViolationId === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Violation recording failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function checkViolation($iViolatorId, $aNewViolation)
    {
        $aExistingViolations = DB::table('violations')
            ->where('violation_violator', $iViolatorId)
            ->where('type_id', $aNewViolation['violationList'])
            ->count();
        $aNewViolation['status'] = $aExistingViolations + 1;
        return $this->recordViolation($iViolatorId, $aNewViolation);
    }

    public function incrementViolation($iViolatorId, $iViolationType)
    {
        $bResult = DB::table('violations')
            ->where('violation_violator', $iViolatorId)
            ->where('type_id', $iViolationType)
            ->increment('violation_status');

        if ($bResult !== 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Violation recording failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function escalateViolation(Request $request)
    {
        $aViolation = $request->all();
        return $this->checkViolation($aViolation['iViolatorId'], $aViolation);
    }

    public function modifyViolation(Request $request)
    {
        $aViolation = $request->all();
        $aModifyData = [
            'violation_date'  => strtotime($aViolation['violationDate']),
            'violation_notes' => $aViolation['violationNotes']
        ];
        $bImage = array_key_exists('violationProof', $aViolation);
        if ($bImage === true) {
            $aViolation = $this->uploadPhoto($aViolation, 'violationProof', '/uploads');
            $aModifyData['violation_photo'] = $aViolation['violationProof'];
        }
        $sFailMessage = 'Violation modify failed. Please try again.';
        return $this->editViolation($aViolation['violationId'], $aModifyData, $sFailMessage);
    }

    public function resolveViolation(Request $request)
    {
        $aResolution = $request->all();
        $aModifyData = ['violation_resolution' => $aResolution['violationResolution']];
        $sFailMessage = 'Violation resolution failed. Please try again.';
        return $this->editViolation($aResolution['iResolution'], $aModifyData, $sFailMessage);
    }

    public function editViolation($iViolationId, $aModifyData, $sFailMessage)
    {
        $bResult = DB::table('violations')
            ->where('violation_id', $iViolationId)
            ->update($aModifyData);

        if ($bResult !== 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => $sFailMessage
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }

    public function generateReport($iViolatorId)
    {
        // $iViolatorId = Input::get('violatorId');
        $aViolator = DB::table('violators')->where('violator_id', $iViolatorId)->first();
        if ($aViolator->violator_mname === 'N/A') {
            $aViolator->violator_mname = '';
        }
        $sViolator = $aViolator->violator_lname . ', ' . $aViolator->violator_fname . ' ' . $aViolator->violator_mname;
        $aUsers = DB::table('users')->get();
        $aTypes = DB::table('types')->get();

        // Set violation types
        $aTypeList = [];
        foreach ($aTypes as $aTempType) {
            $aTypeList[$aTempType->type_id] = $aTempType->type_name;
        }

        // Set users list
        $aUsersList = [];
        foreach ($aUsers as $aTempUsers) {
            $aUsersList[$aTempUsers->account_id] = $aTempUsers->user_lname . ', ' . $aTempUsers->user_fname;
        }

        $aViolations = DB::table('violations')
            ->where('violation_violator', $iViolatorId)
            ->orderBy('type_id', 'desc')
            ->orderBy('violation_status', 'asc')
            ->get()
            ->toArray();
        $aHeadings[] = [
            'Violation Type',
            'Reporter',
            'Offender',
            'Violation Date',
            'Date Filed',
            'Violation Status',
            'Violation Notes',
            'Offence Resolution'
        ];
        $aViolationData = [];
        foreach($aViolations as $aViolation) {
            $sStatus = '';
            if ($aViolation->violation_status === 1) {
                $sStatus = '1st';
            } elseif ($aViolation->violation_status === 2) {
                $sStatus = '2nd';
            } elseif ($aViolation->violation_status === 3) {
                $sStatus = '3rd';
            } else {
                $sStatus = $aViolation->violation_status . 'th';
            }
            $aViolationData[] = [
                'Violation Type'     => $aTypeList[$aViolation->type_id],
                'Reporter'           => $aUsersList[$aViolation->account_id],
                'Offender'           => $sViolator,
                'Violation Date'     => date('m/d/Y', $aViolation->violation_date),
                'Date Filed'         => date('m/d/Y', $aViolation->violation_report),
                'Violation Status'   => $sStatus,
                'Violation Notes'    => $aViolation->violation_notes,
                'Offence Resolution' => $aViolation->violation_resolution
            ];
        }
        $sReportTime = time();
        $sFilename = $sReportTime . '.xlsx';
        $sReportPath = '/reports/' . $sFilename;
        Excel::store(new ReportExport($aHeadings, $aViolationData), '/public' .$sReportPath);
        // return Excel::download(new ReportExport($aHeadings, $aViolationData), $sFilename);


        $iReportId = DB::table('reports')->insertGetId([
            'account_id'  => session()->get('userSession')['account_id'],
            'violator_id' => $aViolator->violator_id,
            'report_path' => '/storage' . $sReportPath,
            'report_date' => $sReportTime
        ]);
        if ($iReportId === null) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Report saving failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true,
            'sFilename' => $sFilename
        ];
        return $this->returnJson($aReturn);
    }

    public function archive()
    {
    	return view('pages.violationArchive');
    }

    public function reportList()
    {
        $aUsers = DB::table('users')->get();
        $aViolators = DB::table('violators')->get();
        $aReports = DB::table('reports')->orderBy('report_id', 'desc')->get();
        return view('pages.reportList', [
            'aViolators'  => $aViolators,
            'aUsers'      => $aUsers,
            'aReports'      => $aReports
        ]);
    }

    public function deleteViolation(Request $request)
    {
        $iViolatorId = $request->input('violationId');
        $bResult = DB::table('violations')
            ->where('violation_id', $iViolatorId)
            ->delete();
        if ($bResult !== 1) {
            $aReturn = [
                'bResult'  => false,
                'sMessage' => 'Delete violation failed. Please try again.'
            ];
            return $this->returnJson($aReturn);
        }
        $aReturn = [
            'bResult' => true
        ];
        return $this->returnJson($aReturn);
    }
}
