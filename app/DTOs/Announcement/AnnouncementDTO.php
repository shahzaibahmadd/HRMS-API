<?php

namespace App\DTOs\Announcement;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class AnnouncementDTO extends BaseDTO
{


    public string $title;
    public string $message;

    public function __construct(Request $request){
        $this->title=$request->input('title');
        $this->message=$request->input('message');

    }

}
