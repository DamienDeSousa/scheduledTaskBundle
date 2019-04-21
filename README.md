# Dades\ScheduledTaskBundle

A Symfony Bundle that schedule tasks and commands on Windows and Linux.

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

Make sure that schtasks is globally install on your system.

### Linux OS

5. You have to tell to your system to check every minute if a task should be run.
To do that, you have to add a cronjob in your crontab:  
    1. run `crontab -e` to edit your crontab

    2. add `* * * * * php /path/to/your/project/bin/console cron:run >> ~/tmp 2>&1` in the file

## How it works

Now you're ready to create all the scheduled tasks you want.
You just need to handle these 2 classes:  
Dades\ScheduledTaskBundle\Entity\ScheduledTask  
Dades\ScheduledTaskBundle\Service\ScheduledTaskService

Inject the service that handles ScheduledTask class:  

```php
use Dades\ScheduledTaskBundle\Service\ScheduledTaskService;

public function indexAction(Request $request, ScheduledTaskService $scheduled)
{
    //code
}
```
Note that this is a Service, so you can inject it where you want.

### Create a scheduled task

Once your Service is injected, you can do the following things:

```php
public function indexAction(Request $request, ScheduledTaskService $scheduledTaskService)
{
    $task = $scheduledTaskService->create();
    $task->setCommand("php --version")->setCronExpresion("* * * * *");
    $scheduledTaskService->save($task);

    return new Response("it works");
}
```

In this example, the "php --version" command will be run every minute.

### Get one or more scheduled tasks

You can get a task by its id or get all tasks in an array.
Example:

```php
public function indexAction(Request $request, ScheduledTaskService $scheduledTaskService)
{
    //get the task with id 1
    $task = $scheduledTaskService->getScheduledTask(1);
    //get all tasks
    $tasks = $scheduledTaskService->getScheduledTasks();

    //...
}
```

### Update a scheduled task

To update a task, just set the value that you want to change and call the ScheduledTaskService:

```php
public function indexAction(Request $request, ScheduledTaskService $scheduledTaskService)
{
    //get the task with id 1
    $task = $scheduledTaskService->getScheduledTask(1);
    $task->setCommand("crontab -l")->setCronExpresion("0 5 * * *");
    $scheduledTaskService->update($task);

    //...
}
```

### Delete a task

You have to get the task that you want to remove and call the delete method:

```php
public function indexAction(Request $request, ScheduledTaskService $scheduledTaskService)
{
    //get the task with id 1
    $task = $scheduledTaskService->getScheduledTask(1);
    $scheduledTaskService->delete($task);

    //...
}
```

### Where the magic happens

Now you know how to install, setup and handle scheduled tasks, but you don't know yet where they are executed.  
Just have a look in the Dades\ScheduledTaskBundle\Command\RunCronCommand class.  

```php
if ($this->scheduledTaskService->isDue($task)) {
    exec($task->getCommand(), $stderr, $status);
```

These 2 lines to the trick.  
The first line check if the task $task must be run now.  
The second line execute the command.

## More informations

The stdout and stderr streams are logged in the var/logs/dades_scheduled_task_bundle.log.  
Thanks to this file, you have a trace of all your task executions.  
If the file doesn't exist, don't worry, it will be automatically created.

This bundle use the dragonmantank/cron-expression library.  
This lib read the cron expression of each task to determine if this task should be run now.  
I invite you to read more about this [here](https://packagist.org/packages/dragonmantank/cron-expression).
