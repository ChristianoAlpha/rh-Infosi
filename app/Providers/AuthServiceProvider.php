<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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
        Gate::define('manage-inventory', fn($user) =>
        in_array(
            $user->employee->department->title,
            [
                'Departamento de Gestão de Infra-Estrutura Tecnológica e Serviços Partilhados',
                'Departamento de Administração e Serviços Gerais'
                ]
        )
    );

    }
}
