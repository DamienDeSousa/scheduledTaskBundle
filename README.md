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
`schtasks /CREATE /TN "uniqueName" /TR "php D:\path\to\your\project\bin\console cron:run" /SC minute`

Make sure that schtasks is globally installed on your system.

### Linux OS

5. You have to tell to your system to check every minute if a task should be run.
To do that, you have to add a cronjob in your crontab:  
    1. run `crontab -e` to edit your crontab

    2. add `* * * * * php /path/to/your/project/bin/console cron:run >> ~/tmp 2>&1` in the file

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
THREAD !

### Running unit tests

From the project root directory, the unit test classes are inside the following directory: `vendor/dades/scheduledtask/Tests/Service/`.  
You can run the following command to launch unit tests: `./vendor/bin/simple-phpunit vendor/dades/scheduledtask/Tests/Service/`.
