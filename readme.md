# Task
Imagine that you have an application with millions of users. Performance is key.
You need to create a backend for it which will handle the following two requests.
The backend has a database which keeps counters for each day, country and event.
Event can be any of "view", "play" or "click"
E.g.

```
2017-07-01 US views 50000
2017-07-01 US plays 100
2017-07-02 US views 3000
2017-07-01 CA clicks 123
```

1. Receive data from application. The data is sent by POST. The data is formatted in json.
The backend needs to decode this data and extract the "country" and "event" fields.
Then the backend needs to increment a counter in the database for the current day
for the respective country and event.

2. The application does a GET request. Data should be returned in different formats (json,csv)
according to the request parameters. The response should contain the sum of each event
over the past 7 days by country for the top 5 countries.
