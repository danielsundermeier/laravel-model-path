<?php

namespace D15r\ModelPath\Tests\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasModelPathTests
{
    protected function testModelPaths(Model $model, array $routes)
    {
        foreach ($routes as $route_name => $route) {
            if ($route_name == 'index_path') {
                $class_name = get_class($model);
                $this->testModelPath($class_name::indexPath(), $route);
            }
            $this->testModelPath($model->$route_name, $route);
        }
    }

    protected function testModelPath(string $model_path, string $route) {
        $this->assertEquals($route, $model_path);
    }
}