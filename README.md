# Dades\ScheduledTaskBundle

A Symfony Bundle that schedule tasks and commands on Windows and Linux.  
It uses the cron system from Linux on both operating systems.

## What's new on this version ?
Overhaul of the hierarchy of entities.  
Managing two kind of command : Console and Symfony command.  
Overhaul of the hierarchy of services.  
Adding service unit tests.  

## Installation
1. Run the following command to add the bundle to your project as a composer dependency:  
`composer require dades/scheduledtask`

2. Add the bundle to your application kernel:  
```php
// app/AppKernel.php
public function registerBundles()
{
    // ...
    $bundle = array(
        // ...
        new Dades\ScheduledTaskBundle\DadesScheduledTaskBundle(),
    );
    // ...

    return $bundles;
}
```

3. If you didn't create your database before, run `php bin/console doctrine:database:create`

4. Then you have to create the table that will store your scheduled tasks:  
`php bin/console doctrine:schema:update --force`

### Windows OS

5. You have to tell to your system to check every minute if a task should be run.
To do that, run the following command on your cmd:  
`schtasks /CREATE /TN "uniqueName" /TR "php D:\path\to\your\project\bin\console dades:scheduled-command:run" /SC minute`

Make sure that schtasks is globally installed on your system.

### Linux OS

5. You have to tell to your system to check every minute if a task should be run.
To do that, you have to add a cronjob in your crontab:  
    1. run `crontab -e` to edit your crontab

    2. add `* * * * * php /path/to/your/project/bin/console dades:scheduled-command:run >> ~/tmp 2>&1` in the file

## How it works

Now you're ready to create all the scheduled tasks you want.
First, you have to choose between a console or a symfony command.  

### Managing a console command

If you want to manage a console command, you have to use the following service:  
`Dades\ScheduledTaskBundle\Service\ScheduledConsoleCommandService` with the tag `dades_scheduled_task_bundle.console_command_service`.  

#### Create a console command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledConsoleCommandService;

public function indexAction(Request $request, ScheduledConsoleCommandService $scheduledConsoleCommandService)
{
    $consoleCommandEntity = $scheduledConsoleCommandService->create();
    $consoleCommandEntity->setCommand('php --version')
        ->setCronExpresion('* * * * *');
    $scheduledConsoleCommandService->save($consoleCommandEntity);

    return new Response('it works');
}
```
The ScheduledConsoleCommandService::create() method returns a new `Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity`.  
You have to set at least the command name and the cron expression.

#### Get one or more console commands

```php
use Dades\ScheduledTaskBundle\Service\ScheduledConsoleCommandService;

public function indexAction(Request $request, ScheduledConsoleCommandService $scheduledConsoleCommandService)
{
    $criteria = [
        'name' => 'php',
        'parameters' => '-v'
    ];
    $scheduledConsoleCommandService->findBy($criteria);
    // it's also possible to order the result, set a limit and an offset.
    
    $scheduledConsoleCommandService->findOneBy($criteria);

    $scheduledConsoleCommandService->findAll();
    // find all console commands.

    $scheduledConsoleCommandService->find($id);
    // find a scheduled console command by its ID. 

    return new Response('it works');
}
```

#### Update a console command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledConsoleCommandService;

public function indexAction(Request $request, ScheduledConsoleCommandService $scheduledConsoleCommandService)
{
    //...
    $consoleCommandEntity->setCommand('php --version');
    $scheduledConsoleCommandService->update($consoleCommandEntity);

    return new Response('it works');
}
```
Update the command of the console command.

#### Delete a console command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledConsoleCommandService;

public function indexAction(Request $request, ScheduledConsoleCommandService $scheduledConsoleCommandService)
{
    //...
    $scheduledConsoleCommandService->delete($consoleCommandEntity);

    return new Response('it works');
}
```
Delete a console command.

### Managing a symfony command

If you want to manage a console command, you have to use the following service:  
`Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService` with the tag `dades_scheduled_task_bundle.symfony_command_service`.

#### Create a symfony command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;

public function indexAction(Request $request, ScheduledSymfonyCommandService $scheduledSymfonyCommandService)
{
    $consoleCommandEntity = $scheduledSymfonyCommandService->create();
    $consoleCommandEntity->setCommand('php --version')
        ->setCronExpresion('* * * * *');
    $scheduledSymfonyCommandService->save($consoleCommandEntity);

    return new Response('it works');
}
```
The $scheduledSymfonyCommandService::create() method returns a new `Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity`.  
You have to set at least the command name and the cron expression.

#### Get one or more symfony commands

```php
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;

public function indexAction(Request $request, ScheduledSymfonyCommandService $scheduledSymfonyCommandService)
{
    $criteria = [
        'name' => 'php',
        'parameters' => '-v'
    ];
    $scheduledSymfonyCommandService->findBy($criteria);
    // it's also possible to order the result, set a limit and an offset.
    
    $scheduledSymfonyCommandService->findOneBy($criteria);

    $scheduledSymfonyCommandService->findAll();
    // find all console commands.

    $scheduledSymfonyCommandService->find($id);
    // find a scheduled symfony command by its ID. 

    return new Response('it works');
}
```

#### Update a symfony command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;

public function indexAction(Request $request, ScheduledSymfonyCommandService $scheduledSymfonyCommandService)
{
    //...
    $consoleCommandEntity->setCommand('php --version');
    $scheduledSymfonyCommandService->update($consoleCommandEntity);

    return new Response('it works');
}
```
Update the command of the console command.

#### Delete a symfony command

```php
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;

public function indexAction(Request $request, ScheduledSymfonyCommandService $scheduledSymfonyCommandService)
{
    //...
    $scheduledSymfonyCommandService->delete($consoleCommandEntity);

    return new Response('it works');
}
```
Delete a console command.

### Running commands

The command `dades:scheduled-command:run` runs both console and symfony commands **synchronously**.

### Running unit tests

From the project root directory, the unit test classes are inside the following directory: `vendor/dades/scheduledtask/Tests/Service/`.  
You can run the following command to launch unit tests: `./vendor/bin/simple-phpunit vendor/dades/scheduledtask/Tests/Service/`.

## More informations

The stdout and stderr streams are logged in the var/logs/dades_scheduled_task_bundle.log.
Thanks to this file, you have a trace of all your task executions.
If the file doesn't exist, don't worry, it will be automatically created.

This bundle use the dragonmantank/cron-expression library.
This lib read the cron expression of each task to determine if this task should be run now.
I invite you to read more about this [here](https://packagist.org/packages/dragonmantank/cron-expression).
