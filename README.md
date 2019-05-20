## User management service

Service assignment - API to manage users and groups.
This is a test task.

### Usage
Modify docker-compose.yml file depending on your needs, and then run:
```
docker-compose up
```

#### Routes

* GET  /groups/{id} - fetch info of a group
* GET  /groups      - fetch list of groups
* POST /groups      - create a group
* PUT  /groups/{id} - modify group info
* PUT  /groups      - modify groups info
-----------------------------------------------------------
* GET /users                     - fetch(retrieve) list of users
* GET /users/{id}?{query_params} - fetch info of a user (query_params - key => value entity filter properties)
* POST /users                    - create a user
* PUT /users                     - modify users info
* PUT /users/{id}                - modify user info

For PUT actions updating multiple entities request format is:
```json
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