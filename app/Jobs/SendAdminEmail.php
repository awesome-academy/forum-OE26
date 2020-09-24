<?php

namespace App\Jobs;

use App\Mail\AdminRecurringMail;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RoleRepositoryInterface $roleRepository)
    {
        $admins = $roleRepository->getUserEmails([config('roles.root_admin'), config('roles.admin')]);

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminRecurringMail);
        }
    }
}
