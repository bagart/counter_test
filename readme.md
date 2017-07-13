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
...
```

1. Receive data from application. The data is sent by POST. The data is formatted in json.
The backend needs to decode this data and extract the "country" and "event" fields.
Then the backend needs to increment a counter in the database for the current day
for the respective country and event.

2. The application does a GET request. Data should be returned in different formats (json,csv)
according to the request parameters. The response should contain the sum of each event
over the past 7 days by country for the top 5 countries.


------------------
# Notice
> application with millions of users.

I use Lavavel for simple and quick example

> over the past 7

over the last 7?

> for the top 5 countries

for the top 5 countries for curent period


# Install
```
git clone https://github.com/bagart/counter_test.git
cd counter_test

git clone https://github.com/Laradock/laradock.git
cd laradock
cp env-example .env
sed -i -e 's/^.*APPLICATION\=.*/APPLICATION=..\/counter/' .env

#run docker images
docker-compose up -d nginx mysql redis php-worker

#connect to prepared workspace
docker exec -it laradock_workspace_1 bash
#next command run inside container:

#install Laravel App
composer install

#prepare Database
./artisan migrate --seed

#check 
phpunit



#for complete queued inc (supervoisord)
php artisan queue:work
```


#show

Envirement: Laradock

https://youtu.be/LhJxdObGr6k
