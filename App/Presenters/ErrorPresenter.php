<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette\Application\Helpers;
use Nette\Application\IPresenter;
use Nette\Application\IResponse;
use Nette\Application\Request;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Tracy\ILogger;

class ErrorPresenter implements IPresenter
{

    /** @var \Tracy\ILogger */
    private $logger;

    public function __construct(ILogger $logger)
    {
        $this->logger = $logger;
    }

    public function run(Request $request): IResponse
    {
        $exception = $request->getParameter('exception');
        if ($exception instanceof \Nette\Application\BadRequestException) {
            [$module, , $sep] = Helpers::splitName($request->getPresenterName());
            return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
        }
        $requestParam = $request->getParameter('request');
        if ($requestParam !== null) {
            $host = $requestParam->getParameter('host');
            if ($host !== null) {
                $this->ravenClient->site = $host;
            }
        }
        $this->logger->log($exception, ILogger::EXCEPTION);
        //$sentryErrorId = $this->ravenClient->getLastEventID();
        return new CallbackResponse(function (): void {
            require __DIR__ . '/../Templates/Error/500.latte';
        });
    }

}
