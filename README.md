# Boostech CTe

Este pacote tem o objetivo de abstrair métodos que permitam ao desenvolvedor manipular arquivos XML provenientes de um CT-e

## 🚀 Começando

Os passos a seguir descreverão a instalação do pacote e a sua utilização

### 📋 Pré-requisitos

Este pacote foi desenvolvido com as seguintes tecnologias:
- PHP 7.4
- Laravel Framework 5.8.38
- Postgresql 12
- Composer version 2.2.6

### 🔧 Instalação

1) Acesse a pasta do projeto na qual você deseja instalar o pacote (lembre-se dos pré-requisitos)
2) Execute o comando:
```
composer require boostech/cte:1.0
```
4) Será criada a pasta vendor/boostech/cte
5) Edite o arquivo /<nome_projeto>/config/app.php e adicione a linha Boostech\Cte\Providers\CteServiceProvider::class dentro da tag providers
```
'providers' => [
    ...
    ...
    ...
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    Boostech\Cte\Providers\CteServiceProvider::class,

],
```
5) Dentro da raiz do diretório do seu projeto, execute os comandos:
```
php artisan optimize
php artisan migrate

```
7) Serão criadas duas tabelas no seu banco de dados:
    - boostech_cte_hctex: Tabela responsável por gerenciar o cabeçalho dos CT-e's
    - boostech_cte_hctei: Tabela responsável por gerenciar os itens das CT-e's

## 📦 Desenvolvimento

Para utilizar o pacote, siga o seguinte exemplo:

1) Salve alguns XML's de CT-e's autorizadas em um determinado diretório
2) Crie no seu projeto um Controller chamado TesteController
3) Adicione o seguinte método a este controller
```
public function teste()
{
    $diretorio = "<diretorio_dos_xmls>";

    foreach (array_diff(scandir($diretorio), array('..', '.')) as $item) {
        $retorno = Hctex::importarXML(1, 2, sprintf("%s/%s", $diretorio, $item));

        if (!$retorno['status']) {
            dd($retorno['excessao']);
        }
    }

    echo "XML's importados!";
}
```
4) Crie uma rota para o método
    'Route::get('/teste', [App\Http\Controllers\TesteController::class, 'teste'])->name('teste.teste');'
5) Acesse a rota http://localhost:8000/teste através do seu browser
6) O sistema realizará a importação dos XML's e caso dê tudo certo, a seguinte mensagem será apresentada: XML's importados!
7) Acesse as tabelas boostech_cte_hctex e boostech_cte_hctei e confira se estão preenchidas

## 📌 Versão

Versão 1.0.0

## ✒️ Autores

* **João Romeiro** - (https://github.com/JoaoRomeiro)

## 📄 Licença

MIT
