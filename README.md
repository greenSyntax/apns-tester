
# :video_game: xAPNS
-----
**xAPNS** is a Web Tool which let you send Push Notifications Messages to your iOS Device.

## Hosted
http://api.greensyntax.co.in/apnsPHP/


## Objective
So, If you have ever worked on Push Notification, then it's always difficult to test the code wheather Push Notifications are coming or not. So, xAPNS will let you do that. What you need in order to test the Push Notifcations,
* APNS Token
* *.pem certificate

## Features
* Woks for both Development and Distribution Certificate
* Customize Your Push Message with JSON
* or, Plain Text Message

## How to Genrate PEM from p12 Certificate
1. First, you need to drag APNS **p12 Certificate** from Developer Portal (if you're not aware of these)
2. Then, convert p12 certificate into **pem** file. And, open your **Terminal**

```
openssl pkcs12 -in pushcert.p12 -out pushcert.pem -nodes -clcerts
```
Here, pushcert.p12 is the name of p12 file. Your's might be different. And, I'm assuming you're in the same

## Payload
Simplest payload would look like,
```
{"aps":{"alert":"This is my ROFL Push Message","badge":0,"sound":"default"}}

```

## Report Bug
If you have any issue with the app, please report an Issue.
You're free to add pull request if you want to contribute in the this project.
