<?php

namespace LogViewerBundle\Formatter;

use Symfony\Component\Templating\EngineInterface;

class HtmlFormatter
{
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param array $logs
     * @param string $view
     * @param $form
     * @param $message
     * @return string
     */
    public function render(array $logs, $view, $form, $message = null)
    {
        return $this->engine->render('LogViewerBundle::index.html.twig', array_merge(
            array(
                'logs' => $logs,
                'count' => count($logs),
                'view' => $view,
                'form' => $form,
                'message' => $message
            ),
            $this->getGlobalVars()
        ));
    }
    /**
     * @return array
     */
    private function getGlobalVars()
    {
        return array(
            'date' => date(DATE_RFC822),
            'css' => file_get_contents(__DIR__ . '/../Resources/public/css/style.css'),
        );
    }
}