<?php

namespace App\Services\Announcement;

use App\DTOs\Announcement\AnnouncementDTO;
use App\Events\Announcement\AnnouncementCreated;
use App\Models\Announcement;
use App\Services\ErrorLogging\ErrorLoggingService;

class AnnouncementService
{

    Public function create(AnnouncementDTO $dto):Announcement|null{
        try{
            $announcement=Announcement::create([
                'user_id'=>auth()->id(),
               ...$dto->toArray(),
            ]);
            broadcast(new AnnouncementCreated($announcement))->toOthers();
            return $announcement;


        }catch (\Throwable $e){
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function getActive()
    {
        return Announcement::where('is_active',true)
            ->orderByDesc('created_at')
            ->get();
    }
}
