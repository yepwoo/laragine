## Introduction

To get started, require the package:

```bash
composer require yepwoo/laragine
```

Note that: Laragine currently is working on **Laravel 8** (`^8.0`).

### Install the package

After including Laragine, you have to install it by running the following command:

```bash
php artisan laragine:install
```

### Notes

* Laragine directory will be in the root directory under `Core` directory

* The system response (including errors response if you applied what's in `Error Handling` section) to any request will be as in below examples (`status_code` is the http status code):

**Success Response:**

```json
{
  "is_success": true,
  "status_code": 200,
  "message": "Success.",
  "data": ...,
  "links": ...,
  "meta": ...
}
```

`links` and `meta` will be provided if the data is **paginated**.


**Error Response:**

```json
{
  "is_success": false,
  "status_code": 401,
  "message": "Error.",
  "errors": ...
}
```