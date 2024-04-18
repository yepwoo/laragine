## Introduction

We developed Laragine to make the software development using Laravel faster and cleaner, so you can get things done faster, not only that, Laragine is not about quantity only, it's all about quantity and quality.

### Features

It's very important to know why to use Laragine, here is why:

* A module based, meaning that you can separate all related stuff together

* You can create CRUD operations including the `requests`, `resources`, `models`, `migrations`, `factories`, `views` ...etc by doing simple stuff (don't worry, it's explained in the documentation)

* Unit Tests are also created!

* One clear response for the client side (for example: API response)

* Many helper functions/traits/classes that will come in handy while you develop! (error handling, adding more info to the logs, security helpers ...etc)

* Configuration! each module has its own configuration

### Structure

![Structure](structure.png)

The `Base` module in the `core` directory is the main module in which every new module will be created (keep reading the other sections to know how), will be derived from.

Also it's worth mentioning that there is another directory called `plugins` for overriding current modules, adding extra functionalities or adding new modules to the system.

It's also very important to understand the following terms:

* `Module` the directory that contains related files that do specific job, for example Blog module or Sale module or Catalogue Module (last 2 modules examples should be in an e-commerce system).

* `Unit` is a part of the module for example Post & Comment units (in Blog Module) and Invoice & Quotation units (in Sale Module).

### Notes

* Laragine currently is working on **Laravel 8.x, 9.x, 10.x and 11.x**

* Laragine directory will be in the root directory under `core` directory and as mentioned above there is also `plugins` directory

* The system response (including errors response if you applied what's in `Error Handling` section) to any request will be as in below examples (`status_code` is the http status code):

* to use pagination you can use the following (ex: index method in the base controller):
`return $this->sendResponse($this->resource::collection($this->model->paginate(30))->response()->getData(true))`

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