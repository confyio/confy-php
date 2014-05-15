# confy-php

Official Confy API library client for PHP

__This library is generated by [alpaca](https://github.com/pksunkara/alpaca)__

## Installation

Make sure you have [composer](https://getcomposer.org) installed.

Add the following to your composer.json

```js
{
    "require": {
        "pksunkara/confyio": "*"
    }
}
```

Update your dependencies

```bash
$ php composer.phar update
```

> This package follows the `PSR-0` convention names for its classes, which means you can easily integrate these classes loading in your own autoloader.

#### Versions

Works with [ 5.4 / 5.5 ]

## Usage

```php
<?php

// This file is generated by Composer
require_once 'vendor/autoload.php';

// Then we instantiate a client (as shown below)
```

### Build a client

__Using this api without authentication gives an error__

##### Basic authentication

```php
$auth = array('username' => 'pksunkara', 'password' => 'password');

$client = new Confy\Client($auth, $clientOptions);
```

### Client Options

The following options are available while instantiating a client:

 * __base__: Base url for the api
 * __api_version__: Default version of the api (to be used in url)
 * __user_agent__: Default user-agent for all requests
 * __headers__: Default headers for all requests
 * __request_type__: Default format of the request body

### Response information

__All the callbacks provided to an api call will recieve the response as shown below__

```php
$response = $client->klass('args')->method('args', $methodOptions);

$response->code;
// >>> 200

$response->headers;
// >>> array('x-server' => 'apache')
```

##### JSON response

When the response sent by server is __json__, it is decoded into an array

```php
$response->body;
// >>> array('user' => 'pksunkara')
```

### Method Options

The following options are available while calling a method of an api:

 * __api_version__: Version of the api (to be used in url)
 * __headers__: Headers for the request
 * __query__: Query parameters for the url
 * __body__: Body of the request
 * __request_type__: Format of the request body

### Request body information

Set __request_type__ in options to modify the body accordingly

##### RAW request

When the value is set to __raw__, don't modify the body at all.

```php
$body = 'username=pksunkara';
// >>> 'username=pksunkara'
```

##### JSON request

When the value is set to __json__, JSON encode the body.

```php
$body = array('user' => 'pksunkara');
// >>> '{"user": "pksunkara"}'
```

### Authenticated User api

User who is authenticated currently.

```php
$user = $client->user();
```

##### Retrieve authenticated user (GET /user)

Get the authenticated user's profile.

```php
$response = $user->retrieve($options);
```

##### Update authenticated user (PATCH /user)

Update the authenticated user's profile

The following arguments are required:

 * __email__: Profile email of the user

```php
$response = $user->update("john@smith.com", $options);
```

### Organizations api

Organizations are owned by users and only (s)he can add/remove teams and projects for that organization. A default organization will be created for every user.

```php
$orgs = $client->orgs();
```

##### List Organizations (GET /orgs)

List all organizations the authenticated user is a member of.

```php
$response = $orgs->list($options);
```

##### Create an organization (POST /orgs)

Create an organization with a name and the email for billing.

The following arguments are required:

 * __name__: Name of the organization
 * __email__: Billing email of the organization

```php
$response = $orgs->create("OpenSourceProject", "admin@osp.com", $options);
```

##### Retrieve an organization (GET /orgs/:org)

Get an organization the user has access to.

The following arguments are required:

 * __org__: Name of the organization

```php
$response = $orgs->retrieve("bigcompany", $options);
```

##### Update an organization (PATCH /orgs/:org)

Update an organization the user is owner of.

The following arguments are required:

 * __org__: Name of the organization
 * __email__: Billing email of the organization

```php
$response = $orgs->update("bigcompany", "admin@bigcompany.com", $options);
```

### Teams api

Every organization will have a default team named Owners. Owner of the organization will be a default member for every team.

The following arguments are required:

 * __org__: Name of the organization

```php
$teams = $client->teams("bigcompany");
```

##### List Teams (GET /orgs/:org/teams)

List teams of the given organization authenticated user is a member of.

```php
$response = $teams->list($options);
```

##### Create a team (POST /orgs/:org/teams)

Create a team for the given organization. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __name__: Name of the team
 * __description__: Description of the team

```php
$response = $teams->create("Consultants", "Guys who are contractors", $options);
```

##### Retrieve a team (GET /orgs/:org/teams/:team)

Get a team the user is member of.

The following arguments are required:

 * __team__: Name of the team

```php
$response = $teams->retrieve("consultants", $options);
```

##### Update a team (PATCH /orgs/:org/teams/:team)

Update a team. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __team__: Name of the team
 * __description__: Description of the team

```php
$response = $teams->update("consultants", "Guys who are contractors", $options);
```

##### Delete a team (DELETE /orgs/:org/teams/:team)

Delete the given team. Cannot delete the default team in the organization. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __team__: Name of the team

```php
$response = $teams->destroy("consultants", $options);
```

### Projects api

An organization can contain any number of projects.

The following arguments are required:

 * __org__: Name of the organization

```php
$projects = $client->projects("bigcompany");
```

##### List projects (GET /orgs/:org/projects)

List all the projects of the organization which can be seen by the authenticated user.

```php
$response = $projects->list($options);
```

##### Create a project (POST /orgs/:org/projects)

Create a project for the given organization. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __name__: Name of the project
 * __description__: Description of the project

```php
$response = $projects->create("KnowledgeBase", "Support FAQ & Wiki", $options);
```

##### Retrieve a project (GET /orgs/:org/projects/:project)

Get a project the user has access to.

The following arguments are required:

 * __project__: Name of the project

```php
$response = $projects->retrieve("knowledgebase", $options);
```

##### Update a project (PATCH /orgs/:org/projects/:project)

Update a project. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __project__: Name of the project
 * __description__: Description of the project

```php
$response = $projects->update("knowledgebase", "Support FAQ and Wiki", $options);
```

##### Delete a project (DELETE /orgs/:org/projects/:project)

Delete the given project. Cannot delete the default project in the organization. Authenticated user should be the owner of the organization.

The following arguments are required:

 * __project__: Name of the project

```php
$response = $projects->destroy("knowledgebase", $options);
```

### Environments api

Every project has a default environment named Production. Each environment has one configuration document which can have many keys and values.

The following arguments are required:

 * __org__: Name of the organization
 * __project__: Name of the project

```php
$envs = $client->envs("bigcompany", "knowledgebase");
```

##### List all environments (GET /orgs/:org/projects/:project/envs)

List all the environmens of the project which can be seen by the authenticated user.

```php
$response = $envs->list($options);
```

##### Create an environment (POST /orgs/:org/projects/:project/envs)

Create an environment for the given project. Authenticated user should have access to the project.

The following arguments are required:

 * __name__: Name of the environment
 * __description__: Description of the environment

```php
$response = $envs->create("QA", "Quality assurance guys server", $options);
```

##### Retrieve an environment (GET /orgs/:org/projects/:project/envs/:env)

Get an environment of the project the user has access to.

The following arguments are required:

 * __env__: Name of the environment

```php
$response = $envs->retrieve("qa", $options);
```

##### Update an environment (PATCH /orgs/:org/projects/:project/envs/:env)

Update an environment. Authenticated user should have access to the project.

The following arguments are required:

 * __env__: Name of the environment
 * __description__: Description of the environment

```php
$response = $envs->update("qa", "Testing server for QA guys", $options);
```

##### Delete an environment (DELETE /orgs/:org/projects/:project/envs/:env)

Delete the given environment of the project. Authenticated user should have access to the project. Cannot delete the default environment.

The following arguments are required:

 * __env__: Name of the environment

```php
$response = $envs->destroy("knowledgebase", $options);
```

### configuration api

Any member of the team which has access to the project can retrieve any of it's environment's configuration document or edit it.

The following arguments are required:

 * __org__: Name of the organization
 * __project__: Name of the project
 * __env__: Name of the environment

```php
$config = $client->config("bigcompany", "knowledgebase", "production");
```

##### Retrieve an config (GET /orgs/:org/projects/:project/envs/:env/config)

Get an environment config of the project.

```php
$response = $config->retrieve($options);
```

##### Update the configuration (POST /orgs/:org/projects/:project/envs/:env/config)

Update the configuration document for the given environment of the project. We will patch the document recursively.

The following arguments are required:

 * __config__: Configuration to update

```php
$response = $config->update(array(
    'database' => array(
        'port' => 6984
    ),
    'random' => "wow"
), $options);
```

## Contributors
Here is a list of [Contributors](https://github.com/asm-products/confy-php/contributors)

### TODO

## License
BSD

## Bug Reports
Report [here](https://github.com/asm-products/confy-php/issues).

## Contact
Pavan Kumar Sunkara (pavan.sss1991@gmail.com)
