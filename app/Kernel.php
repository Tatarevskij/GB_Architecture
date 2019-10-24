<?php

declare(strict_types = 1);

use Framework\Command\CommandRegisterConfig;
use Framework\Command\CommandRegisterRoutes;
use Framework\Registry;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * Kernel constructor.
     * @param ContainerBuilder $containerBuilder
     */
    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request): Response
    {
        (new CommandRegisterConfig(
            __DIR__ . DIRECTORY_SEPARATOR . 'config',
            $this->containerBuilder
        ))->execute();
        (new CommandRegisterRoutes(
            __DIR__ . DIRECTORY_SEPARATOR . 'config',
            $this->containerBuilder
        ))->execute();

        return $this->process($request);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    protected function process(Request $request): Response
    {
        $matcher = new UrlMatcher(
            $this->containerBuilder->get('route_collection'),
            new RequestContext()
        );
        $matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $request->setSession(new Session());

            $controller = (new ControllerResolver())->getController($request);
            $arguments = (new ArgumentResolver())->getArguments($request,
                $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Page not found. 404',
                Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $error = 'Server error occurred. 500';
            if (Registry::getDataConfig('environment') === 'dev') {
                $error .= '<pre>' . $e->getTraceAsString() . '</pre>';
            }
            return new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

