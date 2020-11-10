# Laravel Model Path

Laravel Models know their own routes.

```php
Model::indexPath(); // index, store

$model->index_path; // index, store
$model->create_path; // create
$model->path; // show, update, delete
$model->edit_path; // edit
```

## Installation

You may install the package via Composer:

```
composer require danielsundermeier/laravel-model-path
```

## Usage

### Basics

`routes/web.php`

```php
Route::resource('movies', App\Http\Controllers\Movies\MovieController::class);
```

Models must use the trait `HasModelPath` and have a `const ROUTE_NAME`. 

`app/Models/Movie.php`

```php
use D15r\ModelPath\Traits\HasModelPath;

class Movie extends Model
{
    use HasFactory, HasModelPath;

    const ROUTE_NAME = 'movies';
}
```

```php
Movie::indexPath(); // /movies

$movie = Movie::find(1);

$movie->index_path; // /movies
$movie->create_path; // /movies/create
$movie->path; // /movies/1
$movie->edit_path; // /movies/1/edit
```

### Advanced

`routes/web.php`

```php
Route::resource('{type}/{model}/watched', App\Http\Controllers\Watched\WatchedController::class);
```

`app/Models/Watched.php`

```php
use D15r\ModelPath\Traits\HasModelPath;

class Watched extends Model
{
    use HasFactory, HasModelPath;

    const ROUTE_NAME = 'watched';

    public function getRouteParameterAttribute() : array
    {
        return [
            'type' => $this->watchable_type::ROUTE_NAME,
            'model' => $this->watchable_id,
            'watched' => $this->id,
        ];
    }
}
```

```php
Watched::indexPath([
    'watchable_type' => Movie::class,
    'watchable_id' => 1
]); // /movies/1/watched

$watched = Watched::find(1);

$watched->index_path; // /movies/1/watched
$watched->create_path; // /movies/1/watched/create
$watched->path; // /movies/1/watched/1
$watched->edit_path; // /movies/1//watched/1/edit
```

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be, learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request