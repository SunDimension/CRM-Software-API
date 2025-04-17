<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\StudentDocument;
use App\Models\StudentEmergencyContact;
use App\Models\StudentEducationalQualification;
use App\Models\StudentPersonalInformation;
use App\Models\StudentProgramChoice;
use App\Policies\DocumentPolicy;
use App\Policies\EducationalQualificationPolicy;
use App\Policies\EmergencyContactPolicy;
use App\Policies\PersonalInformationPolicy;
use App\Policies\ProgramChoicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        StudentPersonalInformation::class => PersonalInformationPolicy::class,
        StudentEmergencyContact::class => EmergencyContactPolicy::class,
        StudentEducationalQualification::class => EducationalQualificationPolicy::class,
        StudentProgramChoice::class => ProgramChoicePolicy::class,
        StudentDocument::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Only register permission gates if the permissions table exists
        try {
            $permissions = Permission::with('roles')->get();

            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission->name);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            Log::warning('Permissions table may not exist or is not accessible: ' . $e->getMessage());
        }
    }
}