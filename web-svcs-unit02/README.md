Exercise 1: REST via ZF2 MVC
============================

This directory contains a skeleton application, with a new module, "Status".

That module configures a database and an `AbstractRestfulController`
implementation. Your job is to:

- In `config/module.config.php`:
  - enable the `ViewJsonStrategy` in the `view_manager` configuration.
- In `src/Status/StatusController.php`:
  - Fill in the `isAcceptable()` method. This will exercise your knowledge of
    the `acceptableViewModelSelector()` plugin, as well as of the response
    object. Follow the directions in the method docblock.
  - Fill in the `setEventManager()` method to have it register `isAcceptable()`
    as a `dispatch` listener at high priority.
  - Fill in each of the methods `create()`, `delete()`, `getList()`, and
    `patch()` according to the instructions in each of their docblocks. You will
    use the injected `TableGateway` instance in each. Each method should return
    an appropriate HTTP status code both for errors and success.
- Review the route created, as well as the `Module.php` to ensure you understand
  the routes and services registered.

Try it out
----------

Create a vhost, or, more easily, fire up PHP 5.4's built-in web server in this
directory. Use cURL, httpie, or a browser-based REST console to access the API,
which will be available at the paths denoted by `/api/status[/:id]`.

Try each of the following:

- Retrieving a list of all statuses
- Retrieving a single status
- Creating a status
- Deleting a single status
- Updating a single status
- Attempting each of the above operations on a non-existent, valid identifier
