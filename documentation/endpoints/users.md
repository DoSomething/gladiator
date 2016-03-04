# Users Endpoint

- [Retrieve All Users](#retrieve-all-users)
- [Create A User](#create-a-user)

## Retrieve All Users

## Create A User

```
POST /users
```

**Headers**

```javascript
Accept: application/json
Content-Type: application/json
```

**Body Parameters**

```javascript
{
  // Required.
  key: String

  // Required. Allowed values: email, drupal_id, mobile, id (Northstar ID)
  type: String

  // Required.
  campaign_id: Number

  // Required.
  campaign_run_id: Number
}
```

**Example Request**

```sh
curl -X POST \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"key":"clee@dosomething.org","type":"email","campaign_id":"362","campaign_run_id":"212"}' \
  http://gladiator.dosomething.org/api/v1/users
```

**Example Response**

_TBD_


