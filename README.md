# ci-boulette

L'intégration continue sans boulette.

## Goal

The goal is to make a simplistic web app running on the server receiving these web hooks concerning one or many Github repositories.
This app would respond by running system commands locally to help continuously deploy apps on the server or maintain up-to-date dependencies
to libraries used by apps running on the server.

## Features

Starting simple, the app should be able to log in a unique user, pulling username & password from a config file.
There should be an intuitive web interface allowing the user admin to quickly show which "pull & build" failed,
at which command execution, allowing him to replay some commands from a certain point if necessary, etc...

## Special care

Regarding the rights given to the application on the system, security should be regarded as an essential and mandatory feature of the app.
Special care will be taken to avoid :
   * Non-authorized access to the web administration interface,
   * Leakage in any way of source code from private repos or data from the reports,
   * Denial of Service or remote code execution through the sending of fake Github data to the app,
   * Serious damage accidentally made by the app to the OS or the running apps it's supposed to help continuously deploy.

