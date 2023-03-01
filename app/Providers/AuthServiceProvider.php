<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\FormaPgmto;
use App\Models\Fornecedor;
use App\Models\Funcionario;
use App\Policies\ClientePolicy;
use App\Policies\FornecedorPolicy;
use App\Policies\FuncionarioPolicy;
use App\Policies\PgmtoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Produto::class => ProdutoPolicy::class,
        Cliente::class => ClientePolicy::class,
        FormaPgmto::class => PgmtoPolicy::class,
        Funcionario::class => FuncionarioPolicy::class,
      //  Fornecedor::class => FornecedorPolicy::class
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
