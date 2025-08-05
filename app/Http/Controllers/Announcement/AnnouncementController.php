<?php

namespace App\Http\Controllers\Announcement;

use App\DTOs\Announcement\AnnouncementDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Resources\Announcement\AnnouncementResource;
use App\services\Announcement\AnnouncementService;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function __construct(protected AnnouncementService $announcementService){}

    public function index(){
        $announcements=$this->announcementService->getActive();
        return ResponseHelper::success(AnnouncementResource::collection($announcements),
        "Announcement list");
    }
    public function store(StoreAnnouncementRequest $request){
        $dto= new AnnouncementDTO($request);
        $announcement=$this->announcementService->create($dto);

        if(!$announcement){
            return ResponseHelper::error("Announcement could not be created",500);
        }
        return ResponseHelper::success(new AnnouncementResource($announcement),"Announcement created");
    }

}
