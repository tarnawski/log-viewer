<?php

namespace LogViewerBundle\Controller;

use LogViewerBundle\Exception\DataTransformerException;
use LogViewerBundle\Exception\ReaderException;
use LogViewerBundle\Form\Type\LogCriteriaType;
use LogViewerBundle\Formatter\HtmlFormatter;
use LogViewerBundle\Model\LogCollection;
use LogViewerBundle\DataTransformer\StrategyFactory;
use LogViewerBundle\Reader\LogCommutator;
use LogViewerBundle\Reader\LogReader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogViewerController extends Controller
{
    /**
     * @param string $view
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($view, Request $request)
    {
        /** @var LogReader $logReader */
        $logReader = $this->get('log_viewer.log_reader');
        /** @var StrategyFactory $strategyFactory */
        $strategyFactory = $this->get('log_viewer.strategy_factory');
        /** @var LogCommutator $logCommutator */
        $logCommutator = $this->get('log_viewer.log_commutator');
        /** @var HtmlFormatter $htmlFormatter */
        $htmlFormatter = $this->get('log_viewer.html_formatter');

        $form = $this->createForm(LogCriteriaType::class);
        $conf = $logCommutator->getConfiguration($view);

        if (!$conf) {
            $htmlContent = $htmlFormatter->render([], $view, null, 'Configuration for "' . $view . '" not found!');
            return new Response($htmlContent, 200, array('Content-Type' => 'text/html'));
        }

        try {
            $strategy = $strategyFactory->getStrategy($conf['method']);
        } catch (DataTransformerException $e) {
            $htmlContent = $htmlFormatter->render([], $view, null, $e->getMessage());
            return new Response($htmlContent, 500, array('Content-Type' => 'text/html'));
        }

        try {
            $data = $logReader->readData($conf['path']);
        } catch (ReaderException $e) {
            $htmlContent = $htmlFormatter->render([], $view, null, $e->getMessage());
            return new Response($htmlContent, 500, array('Content-Type' => 'text/html'));
        }

        /** @var LogCollection $logCollection */
        $logCollection = $strategy->transform($data);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            $logs = $logCollection->filterLogs($criteria);
        } else {
            $logs = $logCollection->getLogs();
        }

        if (empty($logs)) {
            $htmlContent = $htmlFormatter->render([], $view, null, 'Logs file for "' . $view . '" not exist or is empty!');
            return new Response($htmlContent, 200, array('Content-Type' => 'text/html'));
        }

        $htmlContent = $htmlFormatter->render($logs, $view, $form->createView());

        return new Response($htmlContent, 200, array('Content-Type' => 'text/html'));
    }
}
