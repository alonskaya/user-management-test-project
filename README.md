## User management service

Service assignment - API to manage users and groups.
This is a test task.

### Usage
Modify docker-compose.yml file depending on your needs, and then run:
```
docker-compose up
```

#### Routes

* GET  api/v1/groups/{id} - fetch info of a group
* GET  api/v1/groups      - fetch list of groups
* POST api/v1/groups      - create a group
* PUT  api/v1/groups/{id} - modify group info
* PUT  api/v1/groups      - modify groups info
-----------------------------------------------------------
* GET api/v1/users                     - fetch(retrieve) list of users
* GET api/v1/users/{id}?{query_params} - fetch info of a user (query_params - key => value entity filter properties)
* POST api/v1/users                    - create a user
* PUT api/v1/users                     - modify users info
* PUT api/v1/users/{id}                - modify user info

For PUT actions updating multiple entities request format is:
```
{
    "filter_params": 
    {
        ...
    },
    "data": 
    {
        ...
    }
}
```
For example, to update creation date of all users in group with id 1, request should be:
```json
{
	"filter_params": {"groups": 1},
	"data" :{
		"creation_date": "2015-05-20T03:58:21+00:00"
	}
}
```
Admin panel also available throw /admin route.

Tests running command:
```
bin/phpunit src/Tests
```
