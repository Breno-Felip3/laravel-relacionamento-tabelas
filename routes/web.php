<?php

use App\Models\{
    Course,
    Module,
    Permission,
    User,
    Preference
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/one-to-one', function(){
    //Busca o primeiro usuário no Banco
    $user = User::find(2);

    $dados = [
        'background_color' => '#000'
    ];

    // caso a preferencia for NULL, salva uma preferencia do usuário no banco
    if ($user->preference == NULL){
        
        $user->preference()->create($dados);
    } else {

        //Se não, atualiza os dados
        $user->preference->update($dados);
    }
  
    //faz uma nova busca no banco para atualizar os atributos do usuário
    $user->refresh();

    dd($user->preference);
    
});

Route::get('/one-to-many', function(){
    // $curso = Course::create(['name' => 'Curso de Laravel']);

    $curso = Course::with('modules.lessons')->find(7);

    echo($curso->name);
    echo('<br>');

    foreach ($curso->modules as $modulo){
        echo("Módulo = {$modulo->name} <br>");

        foreach ($modulo->lessons as $aulas){
            echo("Aulas = {$aulas->name} <br>");
        }
    }

    
    // $aula = $modulo->lessons;

    $dados = [
        'name' => 'Aula x1',
        'video' => 'teste link video'
    ];

    // $modulo->lessons()->create($dados);
   
    
    // dd($curso);

});

Route::get('/many-to-many', function(){
    
    $usuario = User::with('permissions')->find(1);

    $usuario->permissions()->attach([
        1 => ['active' => false],
        3 => ['active' => false]
    ]);

    //  $usuario->permissions()->saveMany([
    //     Permission::find(2),
    //     Permission::find(3)
    //  ]);

     $usuario->refresh();

    dd($usuario->permissions);

});

Route::get('many-to-many-pivot', function(){

    $usuario = User::with('permissions')->find(1);
    
    echo("Usuário = {$usuario->name}");
    echo("<br>");

    foreach ($usuario->permissions as $permissoes){
        echo("Permisão = {$permissoes->name} Active = {$permissoes->pivot->active}");
        echo("<br>");
    }


});


