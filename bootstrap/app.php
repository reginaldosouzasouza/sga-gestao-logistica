<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckModule;
use App\Http\Middleware\VerificaEmpresaAtiva;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {  
        $middleware->alias([
            'module' => CheckModule::class,
            'nocache' => \App\Http\Middleware\NoCache::class,
            'permissao' => \App\Http\Middleware\CheckPermissao::class,
            'empresa.ativa' => VerificaEmpresaAtiva::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();