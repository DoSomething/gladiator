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
  // Required. An id for a user, either an email address, drupal_id, mobile phone number or Northstar id.
  id: String

  // Required. Allowed values: "email", "drupal_id", "mobile", "id" (Northstar ID)
  term: String

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
  -d '{"key":"kallark@dosomething.org","type":"email","campaign_id":"362","campaign_run_id":"212"}' \
  http://gladiator.dosomething.org/api/v1/users
```

**Example Response**

```javascript
// 200 Okay

{
  "data": {
    "id": "550200bba39awieg467a3cg2",
    "first_name": null,
    "last_name": null,
    "email": null,
    "mobile": null,
    "signup": null,
    "reportback": null,
    "created_at": "2016-03-08T18:27:10+0000",
    "updated_at": "2016-03-08T18:27:10+0000"
  }
}
```


