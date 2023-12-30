<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Events\BackupWasSuccessful;

class BackupSuccessfulListener
{

    public function handle(BackupWasSuccessful $event)
    {

        $backupPath = url(Storage::url($event->backupDestination->newestBackup()->path()));

        $backupFileName = $event->backupDestination->backupName();

        $emailTo = "philnjugunah+fanaka_website_backup_db@gmail.com";
        $emailFrom = "philipnjuguna66@gmail.com";

        Mail::raw("Database backup", fn($message) => $message->to($emailTo)
            ->from($emailFrom)
            ->cc([
                "virtualtech.ke@gmail.com"
            ])
            ->subject('Website Database Backup')
            ->attach($backupPath, ['as' => $backupFileName.".zip"])
        );


    }
}
