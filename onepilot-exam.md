## How would you improve this project from a code perspective ?


### Route grouping
In the routing file, we can see a lot of similar lines for each services. For example the routes for Organizations services :

```php
Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');
```

The middlewares are the same (Auth) and we can see the prefix for the url are the same (organizations) for these routes.
So we can do a route group with the auth middleware parameter and the organizations prefix.
We can also group the routes verbs into a route resource where we will find Index, create, store, show, edit, update and destroy. We only have to add the restore route.

Example: 
```php
// Organizations
Route::group(['middleware' => 'auth', 'prefix' => 'organizations'], function () {
    Route::resource('organizations', OrganizationsController::class);
}
```

### Database Seeder
All functions are grouped in one file 'DatabaseSeeder', if we want to seed a new table, we have to rerun the file, and it will trigger an error.
For each services, It's better to make unique seed file.


### Test Driven Development
The tests for example the forgot password page are not implemented but we can add more unit tests and then write a code with the TDD method by writing each test before writing the source code and then reshuffling the continuous code. It avoid less bugs and It's a gain of time.

### Redundant scope filter function
The scope filter function is present several times, we can find it in Organization, Contact, User and Report model, which is redundant.
In these functions we only have the name of the table fields which are variable. 
We can make a function that applies to each models.



## How would you improve this project from a product (features) perspective ?

### Sorting tables
Sometimes it is useful to sort the tables, so that we can see at a glance which is the most important or popular response.
For example in the report page, if the table is sorted by date, we would like to quickly know which is the oldest or most recent report.

### Improve the dashboard
Usually in the CRM dashboard, we can see the metrics that matter most. It's also called KPI, in order to have a global vision of the application, or the performance of the company.
We can also find shortcut tabs to the different services (Organizations, Reports, ...)
