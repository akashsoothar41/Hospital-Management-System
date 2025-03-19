<?php

namespace App\Http\Controllers;
use App\Models\User;
use Storage;
abstract class Controller
{

    public  function storeFile($folderName,$file){
        try{
            return Storage::disk('backend')->put($folderName, $file);
        }catch(\Exception $e){
            return '';
        }//end trycatch.
    }//end storeImage function.


}

