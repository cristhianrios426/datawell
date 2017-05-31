<?php
namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\ORM\Location' => 'App\Policies\LocationPolicy',
        'App\ORM\Service' => 'App\Policies\ServicePolicy',
        'App\ORM\Well' => 'App\Policies\WellPolicy',
        'App\ORM\Setting' => 'App\Policies\SettingPolicy',
        'App\ORM\Attachment' => 'App\Policies\AttachmentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
