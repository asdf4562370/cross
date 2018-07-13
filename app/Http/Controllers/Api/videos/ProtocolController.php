<?php

namespace App\Http\Controllers\Api\videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProtocolController extends Controller
{
    public function publishingRule(){
        return view('videos.publishing_rule');
    }
}
