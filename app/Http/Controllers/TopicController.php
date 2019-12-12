<?php

namespace App\Http\Controllers;

use App\Phphub\Core\CreatorListener;
use Illuminate\Http\Request;

class TopicController extends Controller implements CreatorListener{

    public function index(Request $request,Topic $topic){


    }


    public function creatorFailed($errors)
    {
        // TODO: Implement creatorFailed() method.
    }

    public function creatorSucceed($model)
    {
        // TODO: Implement creatorSucceed() method.
    }
}

