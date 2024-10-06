<?php

namespace App\Models;

use App\Models\JobOportunity;
use Illuminate\Support\Facades\Notification;
use App\Notifications\JobOportunityRequested;
use App\Notifications\JobOportunityAccepted;
use App\Models\User;


class JobOportunityObserver
{
    public function created(JobOportunity $JobOportunity)
    {
      

     
        Notification::send(User::where('role', 'admin')->get(), new JobOportunityRequested($JobOportunity));
        
    }

    public function updated(JobOportunity $jobOportunity)
    {
    
    if ($jobOportunity->wasChanged('status') && $jobOportunity->status === 'Publicado') {
        $areaManager = $jobOportunity->area_managers;
        
        if ($areaManager) {
            Notification::send($areaManager->users, new JobOportunityAccepted($jobOportunity));
        }

        
    }
    }
}
