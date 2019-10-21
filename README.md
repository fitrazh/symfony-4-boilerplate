simple api using docker and symfony 4
========
## Installation

First, build the docker images

`docker-compose build`

Run the containers

`docker-compose up -d`

Now shell into the PHP container

`docker-compose exec php-fpm bash`

And install all the dependencies

`composer install`


#### Creating the database schema

Once you've installed the dependencies, you may now create a database and the schema. 

You can do this by running the script, which will create a clean database and schema.

`bash install-clean.sh`

**Note: This script will actually delete any database internal on (current docker) that's already created, so be careful when using this.

#### Fixtures

If you want to create the database with some fixtures, you may run the script 

`bash install-import-fixtures.sh`

**Note: This script will actually delete any database that's already created, so be careful when using this.


## Docker

To run the application in development mode

`docker-compose up -d`

## Clear Cache

Shell into the PHP container

`docker-compose exec php-fpm bash`

If you need To clear the cache, run the script with the environment parameter

`bash cacl.sh prod`

`bash cacl.sh dev`

To make sure our step is Ok, lets check our url: `http://localhost:8000/`


**Note:IF you found error "Table not Found" when running the request, please follow this step:

create this table into mysql docker 
to make sure where is mysql running, you can run this command:
`sudo systemctl status docker`

Return:
`
CGroup: /system.slice/docker.service
           ├─11789 /usr/bin/dockerd -H fd:// --containerd=/run/containerd/containerd.sock
           ├─19729 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 3311 -container-ip 172.19.0.3 -container-port 3306
           ├─19759 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 8001 -container-ip 172.19.0.4 -container-port 80
           ├─26796 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 8080 -container-ip 172.20.0.2 -container-port 8080
           ├─26850 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 8307 -container-ip 172.20.0.4 -container-port 3306
           ├─26904 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 8000 -container-ip 172.20.0.5 -container-port 80
           └─26965 /usr/bin/docker-proxy -proto tcp -host-ip 0.0.0.0 -host-port 8306 -container-ip 172.20.0.6 -container-port 3306 <-- this is our mysql`


`you need to connect to this host 172.20.0.6:3306 sql 
username: sf4_user
password: sf4_pw
db: sf4_db`

and run this query:

`CREATE TABLE user_reward (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(35) DEFAULT NULL, range_min DOUBLE PRECISION NOT NULL, range_max DOUBLE PRECISION NOT NULL, reward DOUBLE PRECISION NOT NULL, balance_rewards DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'`



## Request, example:

1-Register User Methode:[POST]
`http://localhost:8000/api/auth/register`
body json
`{"username":"super","password":"super", "email":"super@yomail.com"}`
RETURN:
`{"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzE2MTkzNjAsImV4cCI6MTU3MTYyMjk2MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoicGF0YXRhIn0.UO7ExnSzoTtAeIbHI11mW_bmWHANxhVeLBjCS1Dqs9YI4IFCzbHYROVUAm-gD9nhqZ2AZsAqsI-Ee5fT8pZA8-r02JmZIgLiN4sem5UHOg-D19U1ubfkNF2XV0hYwduZGLi2RaYkIEQHJJnHH8OhWB9gDaLdq5j2VVLpf8O_WIZ8bK-NM03BVea95uauhuujsHO4Io865DJBhbUqqqoh4kaDdGT13KyNeQ0G0nTgcVHjlgaUNxpUm7Jcr781JRNzAIliWN-Qwjm5I8WCu6IwtBrQxM9vrx-AxM779hCM7N0shwjbp7CTsWhNT9KEC2P6jpStXs74QBHfT6-LNaQvmDFcpjcshJMX4gWk7x9sy9YZr8_AblCux_KnZGecFozsc2W7avZ2Hf7WiRYkGikTABQxUyHtXyCZMaLBg9htbbyCOo3Ae9j_Z8-fRk9dEtvBRDMMrOu-ouCyk3obJoia-kk7CvGqde7iPT_f51WQJEuw91el8IrDpIx0b5JpjWA2okr_G2MTIVT_wXbGymLfBuDqChGP_3me5C4mSkCTBktFsBWcmfMJCnq2i-DwFMPTuNE_zhpOibDNXRZbGaIRH4cZ8dE_VplDz4bZxbFeRGdKlClU4Vi5u4ifI1Y44uyUmv4c2DPxk4dJgXSbGlJrnqsNQMSAYtVgvif9wYrD0Pc"}`



2-Login User Methode:[POST]

`http://localhost:8000/api/auth/login`

body json:

`{"username":"patata","password":"fregida"}`

RETURN:
`{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzE2MjM2ODYsImV4cCI6MTU3MTYyNzI4Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoicGF0YXRhIn0.r25F_yX-d8tEa2JGmX2LkFGillvQaQDVql2nwE3fJco9yAH7WApc-NaopXwx6_88u7azZ6kZop6madVqZzKNKtQFBOSEKsqNPuXxlQmfDbo5fN--_Iwf4aE2mS1nxZvubdADoABMq9IC4Xoux91dgwbiDf4SMbCdPQghRvLWgu2xB1ZRkzifnbkz-LyebKiH8o-s-7aIfJaXnlx8UcOXx0SZ_LFT4vURozTgad1jSGgMNC5jSEAGDAgGqS2oTtVTT8lxA6eqsxG_gXyFoAD0Yt5BwXGtKkPCTwDS3gDNtlqY6lqe2Ztq9TYEUJsJRzSezKw9feMyrXPebkLkS9hkrJDxzbULjkxgzPxv43q3WUx_Prnu2b4KFyNVVUId1l-ed2m3J8SG3YPemTvzmaDLWymq9zq4Uxs8KC7Z7LITSlLUNlYxXfyv9wUTnMm0uJYPIKxV7MEK2WdcOq6_q2ujM5rLu7LZX9Al4387lZJpRU9t2_rtqKDHZ7P7oM-T34HGwADOI8dNzjAozhJ-uVvnAp4MbHo8Y5XycRoVkZUW7cexvCVaPFx6eyTJJ1IR7klZSx7kakhBOu_QeXnqFAGKPUGoytq7KBVGVl0t-rfW1WsZYRItOUEPEddS5gsdBd8K52nFYTrq9SWqHVNe3-bbE69n9RBi-6zx8Tl_eVptQ7Y"}`



3-Login

`http://localhost:8000/api/user/1`

Auth Bearer Token

`eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzE2MjM2ODYsImV4cCI6MTU3MTYyNzI4Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoicGF0YXRhIn0.r25F_yX-d8tEa2JGmX2LkFGillvQaQDVql2nwE3fJco9yAH7WApc-NaopXwx6_88u7azZ6kZop6madVqZzKNKtQFBOSEKsqNPuXxlQmfDbo5fN--_Iwf4aE2mS1nxZvubdADoABMq9IC4Xoux91dgwbiDf4SMbCdPQghRvLWgu2xB1ZRkzifnbkz-LyebKiH8o-s-7aIfJaXnlx8UcOXx0SZ_LFT4vURozTgad1jSGgMNC5jSEAGDAgGqS2oTtVTT8lxA6eqsxG_gXyFoAD0Yt5BwXGtKkPCTwDS3gDNtlqY6lqe2Ztq9TYEUJsJRzSezKw9feMyrXPebkLkS9hkrJDxzbULjkxgzPxv43q3WUx_Prnu2b4KFyNVVUId1l-ed2m3J8SG3YPemTvzmaDLWymq9zq4Uxs8KC7Z7LITSlLUNlYxXfyv9wUTnMm0uJYPIKxV7MEK2WdcOq6_q2ujM5rLu7LZX9Al4387lZJpRU9t2_rtqKDHZ7P7oM-T34HGwADOI8dNzjAozhJ-uVvnAp4MbHo8Y5XycRoVkZUW7cexvCVaPFx6eyTJJ1IR7klZSx7kakhBOu_QeXnqFAGKPUGoytq7KBVGVl0t-rfW1WsZYRItOUEPEddS5gsdBd8K52nFYTrq9SWqHVNe3-bbE69n9RBi-6zx8Tl_eVptQ7Y` 

4-generate Reward

`http://localhost:8000/reward`

RETURN

`"[{\"name\":\"deni\",\"rangeMin\":10000,\"rangeMax\":20000,\"reward\":19724,\"dailyLimit\":180276},{\"name\":\"Gilbert\",\"rangeMin\":45000,\"rangeMax\":75000,\"reward\":66922,\"dailyLimit\":113354},{\"name\":\"Brandon\",\"rangeMin\":60000,\"rangeMax\":80000,\"reward\":64156,\"dailyLimit\":49198},{\"name\":\"Tere\",\"rangeMin\":30000,\"rangeMax\":50000,\"reward\":48659,\"dailyLimit\":539},{\"name\":\"Jil\",\"rangeMin\":25000,\"rangeMax\":35000,\"reward\":539,\"dailyLimit\":0},{\"name\":\"Jil_super\",\"rangeMin\":155000,\"rangeMax\":200000,\"reward\":0,\"dailyLimit\":0}]"`


