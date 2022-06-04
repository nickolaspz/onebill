In order for all request to hit index.php, modify nginx to have the following:

location / {
    try_files $uri $uri/ /index.php?$args;
}