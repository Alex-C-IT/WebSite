<?php 
namespace App;

use AltoRouter;
use App\Security\ForbiddenException;

class Router
{   /**
    * @var string
    */ 
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;


    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('GET', $url, $view, $name);

        return $this;
    }

    public function post(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('POST', $url, $view, $name);

        return $this;
    }

    public function match(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('POST|GET', $url, $view, $name);

        return $this;
    }

    public function url(string $name, array $params = []) 
    {
        return $this->router->generate($name, $params);
    }

    public function run() : self
    {
        $match = $this->router->match();
        $view = !empty($match['target']) ? $match['target'] : null;
        if($view === null) {
            $view = 'errors'. DIRECTORY_SEPARATOR .'404';
        }
        if(!empty($match['params'])) {
            $params = $match['params'];
        } else {
            $params = null;
        }
        $router = $this;
        
        $isAdmin =  strpos($view, 'admin/') !== false ? true : false;
        $isClient = strpos($view, 'espaceperso/') !== false ? true : false;
        if($isAdmin)
            $layout = 'admin/layouts/';
        else if ($isClient) 
            $layout = 'espaceperso/layouts/';
        else
            $layout = 'layouts/';

        try {
            ob_start();
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
            $content = ob_get_clean();
            require $this->viewPath . DIRECTORY_SEPARATOR . $layout . 'default.php';
        } catch (ForbiddenException $e) {
            header('Location: ' . $this->url('app_login') . '?fordidden=1');
        }


        return $this;
    }
}

?>