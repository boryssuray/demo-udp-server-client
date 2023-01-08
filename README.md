DEMO CLIENT-SERVER INTERACTION THROUGH UDP SOCKET
=================================================

>Warning: for demo purposes only

### Deploy local environment

- `docker-compose build`
- `docker-compose up -d`
- `docker ps` 
- `udp-server-demo` and `udp-client-demo` containers should be in the list

### Run server
- `docker exec -it udp-server-demo bash`
- from the container run `php app.php`

### Run client
- open new terminal
- `docker exec -it udp-client-demo bash`
- from the container run `php app.php`
- try communication
- press `CTRL + C` to stop client/server

### Optionally - use netcat as a client
- `nc -u localhost 9999`
- try communication

