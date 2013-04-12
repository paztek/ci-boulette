# ci-boulette

L'intégration continue sans boulette.

## Goal

Github provides "web hooks" : a way for any Internet facing web server to receive a POST request at each commit on a repo with all the relevant infos concerning the commit.

The goal is to make a simplistic web app running on the server receiving these web hooks concerning one or many Github repositories.
This app would respond by running system commands locally to help continuously deploy apps on the server or maintain up-to-date dependencies
to libraries used by apps running on the server.

## Features

Starting simple, the app should be able to log in a unique user, checking username & password against a config file.
There should be an intuitive web interface allowing the user admin to quickly show which "pull & build" failed,
at which command execution, allowing him to replay some commands from a certain point if necessary, etc...

Cool graphs and real time updates are a plus.

## Special care

Regarding the rights given to the application on the system, security should be regarded as an essential and mandatory feature of the app.
Special care will be taken to avoid :
   * Non-authorized access to the web administration interface,
   * Leakage in any way of source code from private repos or data from the reports,
   * Denial of Service or remote code execution through the sending of fake Github data to the app,
   * Secure storage of ssh keys,
   * Serious damage accidentally made by the app to the OS or the running apps it's supposed to help continuously deploy.

