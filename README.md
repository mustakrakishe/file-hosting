# File Hosting

A simple file hosting application.

## Description

The app allows you to upload files asynchronously, review its list and delete them. Also expired files (> 24h) are deleted automatically. On every deletion a notification is sent to admin email.

## Requirements

- [Git](https://git-scm.com)
- [Docker](https://www.docker.com)

## Install

1. Clone this repository:
```
git clone https://github.com/mustakrakishe/file-hosting.git
```

2. Go to created directory:
```
cd file-hosting
```

3. Run a setup script:
```
bin/setup.sh
```
Done.

## Usage

The application is available now at http://localhost.

A log mailer driver is used, so you can see emails in `storage/logs/laravel.log`.

To see some async impact (e.g. new uploaded files) you should to reload page manually.