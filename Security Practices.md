## This File will explain the best ways of keeping FusionGen Secure from hackers, follow these steps to help you from getting PWNED.
1. Ensure you are upto date with the latest FusionGEN

2. Disable non-essential modules:
- GM Panel
- Private Messaging
- Shoutbox
- Teleport Hub

3. Use HTTPS

4. Host your Webserver with FusionGEN on a different Server / IP to your World server.

5. Create a specific database user to be used with FusionGEN, give this a secure password.

5a. Create the same user on the world database sql server.

6. Restrict the database users by their IP address within the MYSQL databases.

6a. For the webserver mysql account, set localhost under "host" for the user account that the website will use.

6b. For the gameserver mysql account, set the IP address of the webserver the connections originate from for the user account under "host"

7. For the newly created SQL accounts, set the mysql priveledges for only the permissions that are required. 
- Remove the following permissions from ALL Accounts:
 Drop, Grant
- Remove the following from the account on the gameserver:
Delete, Reload, Shutdown, Super


8. DO NOT USE PHPMYADMIN.

