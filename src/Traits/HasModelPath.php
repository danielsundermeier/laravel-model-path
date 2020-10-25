<?php

namespace D15r\ModelPath\Traits;

use Illuminate\Support\Str;

trait HasModelPath
{
    public function initializeHasModelPath()
    {
        if (is_null($this->id)) {
            return;
        }

        $this->append([
            'create_path',
            'edit_path',
            'index_path',
            'path',
        ]);
    }

    public static function indexPath(array $attributes = []) : string
    {
        $instance = new static($attributes);

        return $instance->index_path;
    }

    public function getPathAttribute()
    {
        return $this->path('show');
    }

    public function getcreatePathAttribute()
    {
        return strtok($this->path('create'), '?');
    }

    public function getEditPathAttribute()
    {
        return $this->path('edit');
    }

    public function getIndexPathAttribute()
    {
        return strtok($this->path('index'), '?');
    }

    protected function path(string $action = '') : string
    {
        return route($this->base_route . '.' . $action, $this->route_parameter);
    }

    protected function getBaseRouteAttribute() : string
    {
        return self::ROUTE_NAME;
    }

    public function getRouteParameterAttribute() : array
    {
        return [
            Str::singular($this->base_route) => $this->id
        ];
    }
}

?>