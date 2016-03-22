# Contest Endpoint

- [Retrieve All Contests] (#retrieve-all-contests)

## Retrieve All Contest

```
GET /api/v1/contests
```

**Headers**

```javascript
Accept: application/json
Content-Type: application/json
```

**URL Parameters**

```javascript
  // Optional. Find a contest based on specified campaign run id.
  campaign_run_id: Number
```

**Example Request**

```sh
curl -X POST \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  http://gladiator.dosomething.org/api/v1/contests
```

**Example Response**

```javascript
// 200 Okay

{
  "data": {
    "id": 1,
    "campaign": {
      "id": 118,
      "campaign_run": {
        "id": 1969
      }
    },
    "waiting_room": {
      "open": false,
      "signup_dates": {
        "start": "2016-03-10T14:47:27+0000",
        "end": "2016-03-17T23:59:59+0000"
      }
    }
  }
}
```
