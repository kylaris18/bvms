<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function returnJson($aReturn)
    {
    	return json_encode($aReturn, true);
    }

    protected function checkMiddleName($aViolation)
    {
    	if ($aViolation['nameInit'] === null) {
    		$aViolation['nameInit'] = 'N/A';
    	}
    	return $aViolation;
    }

    protected function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    protected function uploadPhoto($aDetails, $sPhoto, $sFolder)
    {
        $sFile = '';
        if (array_key_exists($sPhoto, $aDetails) === true) {
            $oImage = $aDetails[$sPhoto];
            $sFilename = time();
            $sFile = $this->uploadOne($oImage, $sFolder, 'public', $sFilename);
        }
        $aDetails[$sPhoto] = '/storage/' . $sFile;
        return $aDetails;
    }
}
