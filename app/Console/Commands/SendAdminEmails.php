<?php

namespace App\Console\Commands;

use App\Jobs\SendAdminEmail;
use App\Repositories\Role\RoleRepository;
use Illuminate\Console\Command;

class SendAdminEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send report email to admins.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SendAdminEmail::dispatch();

        return 0;
    }
}
