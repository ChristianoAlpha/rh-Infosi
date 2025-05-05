<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Employeee;
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
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-inventory', function ($user) {
            // Se for Admin, recupera o Employeee relacionado
            if ($user instanceof Admin) {
                $deptTitle = $user->employee->department->title ?? null;
            }
            // Se for Employeee direto
            elseif ($user instanceof Employeee) {
                $deptTitle = $user->department->title ?? null;
            } else {
                return false;
            }

            return in_array($deptTitle, [
                'Departamento de Gestão de Infra-Estrutura Tecnológica e Serviços Partilhados',
                'Departamento de Administração e Serviços Gerais',
            ]);
        });
    }
}
